<?php

namespace Modules\Iwhmcs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//Transformers
use Modules\Iwhmcs\Services\Bitrix24\CRest;
use Modules\Iwhmcs\Transformers\DealProductsToBitrix24Transformer;
//Services
use Modules\Iwhmcs\Transformers\DealsToBitrix24Transformer;

class syncInvoicesByContactToBitrix implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logTitle;

    protected $tblOptInvoiceOtherProductsType;

    protected $tblOptInvoiceWebProductType;

    protected $webProductsId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logTitle = '[IWHMCS]::JOB syncInvoicesToBitrix';
        $this->tblOptInvoiceOtherProductsType = 'bitrixDealOtherProducts';
        $this->tblOptInvoiceWebProductType = 'bitrixDealWebProducts';
        $this->webProductsId = [81, 82, 84, 85, 86, 87, 160, 330, 331, 332, 75, 76, 77, 333, 334, 335];
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //dd(CRest::call('crm.deal.get', ["id" => '78536']));
        $this->dispatchInvoicesByContactBatch();
    }

    //Get invoices by contacts
    public function dispatchInvoicesByContactBatch()
    {
        try {
            /*$numBatchs = 1;//Batchs quanitty
            $quantityPerBatch = 5380;//Define record quantity to generate batch

            for ($batch = 0; $batch <= $numBatchs; $batch++) {*/
            //Get WHMCS clients
            $clients = \DB::connection('whmcs')->table('tblclients')
              ->select('tblclients.*', \DB::raw("(SELECT value FROM tblimoptions WHERE rel_id = tblclients.id and type = 'bitrixContactId' limit 1) as bitrixContactId"))
              ->whereNotIn('tblclients.id', [1, 6])
              ->whereIn('id', function ($q) { //Only contacts with bitrix id
              $q->select('rel_id')->from('tblimoptions')->where('type', 'bitrixContactId');
              })
              ->get();

            //Get invoice items by client
            foreach ($clients as $clientIndex => $client) {
                //Get all client invoice items
                $invoiceItems = \DB::connection('whmcs')->table('tblinvoiceitems')
                  ->select(
                      'tblinvoiceitems.*', 'tblhosting.packageid as productId',
                      'tblimoptions.value as bitrixProductId'
                  )
                  ->leftJoin('tblhosting', 'tblhosting.id', 'tblinvoiceitems.relid')
                  ->leftJoin('tblimoptions', function ($join) {
                      $join->on('tblimoptions.rel_id', 'tblhosting.packageid');
                      $join->on('tblimoptions.type', '=', \DB::raw("'bitrixProductId'"));
                  })
                  ->where('tblinvoiceitems.userid', $client->id)
                  ->where('tblinvoiceitems.relid', '>=', 1)
                  ->get();

                //Sync Web products deal
                $webProducts = $invoiceItems->whereIn('productId', $this->webProductsId);
                if ($webProducts && $webProducts->count()) {
                    //Sync Deal
                    $dealId = $this->syncDealByClientToBitrix([
                        'client' => $client,
                        'optType' => $this->tblOptInvoiceWebProductType,
                        'products' => $webProducts,
                        'dealName' => 'Web Products',
                        'invoicesId' => $webProducts->pluck('invoiceid'),
                    ]);
                    //Sync deal products
                    $this->syncProductsDeal((object) ['dealId' => $dealId, 'products' => $webProducts]);
                }

                //Sync Other products deal
                $othersProducts = $invoiceItems->whereNotIn('productId', $this->webProductsId);
                if ($othersProducts && $othersProducts->count()) {
                    //Sync Deal
                    $dealId = $this->syncDealByClientToBitrix([
                        'client' => $client,
                        'optType' => $this->tblOptInvoiceOtherProductsType,
                        'products' => $othersProducts,
                        'dealName' => 'Others Products',
                        'invoicesId' => $othersProducts->pluck('invoiceid'),
                    ]);
                    //Sync deal products
                    $this->syncProductsDeal((object) ['dealId' => $dealId, 'products' => $othersProducts]);
                }

                //Log
                \Log::info("Sync Deal | Client ID {$client->id} | Products ".$invoiceItems->count().' | Record ('.$clientIndex.'/'.count($clients).')');
            }
            //}
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::syncInvoicesToBitrix Failed ".json_encode($e->getMessage()));
        }
    }

    //Sync deals to Bitrix
    public function syncDealByClientToBitrix($params)
    {
        try {
            //Default response
            $response = false;

            //Parse params
            $params = json_decode(json_encode($params));

            //Search rel with bitrix
            $dealBitrixRel = \DB::connection('whmcs')->table('tblimoptions')
              ->where('rel_id', $params->client->id)
              ->where('type', $params->optType)
              ->first();

            //Get first invoices
            $firstInvoice = \DB::connection('whmcs')->table('tblinvoices')->whereIn('id', $params->invoicesId)
              ->whereNotNull('date')->orderBy('date', 'asc')->first();
            //Get last invoices
            $lastInvoice = \DB::connection('whmcs')->table('tblinvoices')->whereIn('id', $params->invoicesId)
              ->whereNotNull('date')->orderBy('date', 'desc')->first();

            //Transform clients to bitrix64
            $params->client->dealName = $params->dealName;
            $params->client->bitrixId = $dealBitrixRel->value ?? null;
            $params->client->firstInvoice = $firstInvoice;
            $params->client->lastInvoice = $lastInvoice;
            $dealBitrix = json_decode(json_encode(new DealsToBitrix24Transformer($params->client)));

            if ($dealBitrixRel) {//Update Deal
                $result = CRest::call('crm.deal.update', ['id' => $dealBitrixRel->value, 'fields' => $dealBitrix]);
                //Set response
                $response = $dealBitrixRel->value;
            } else {//Create Deal
                $result = CRest::call('crm.deal.add', ['fields' => $dealBitrix]);
                //Save relation
                \DB::connection('whmcs')->table('tblimoptions')->insert([
                    'name' => $params->optType,
                    'type' => $params->optType,
                    'rel_id' => $params->client->id,
                    'value' => $result['result'],
                ]);
                //Set response
                $response = $result['result'];
            }

            //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
            usleep(600000);

            //Response
            return $response;
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::syncInvoicesToBitrix Failed | Client ID {$params->client->id} | ".json_encode($e->getMessage()));
        }
    }

    //Sync invoices to Bitrix
    public function syncProductsDeal($params)
    {
        try {
            //Transform
            $dealProducts = collect(json_decode(json_encode(DealProductsToBitrix24Transformer::collection($params->products))));

            //Group products
            $groupProducts = collect();
            foreach ($dealProducts as $product) {
                if (! $groupProducts->where('PRODUCT_ID', $product->PRODUCT_ID)->count()) {
                    $product->QUANTITY = $dealProducts->where('PRODUCT_ID', $product->PRODUCT_ID)->count();
                    $product->PRICE = ($dealProducts->where('PRODUCT_ID', $product->PRODUCT_ID)->sum('PRICE') / $product->QUANTITY);
                    $groupProducts->push($product);
                }
            }

            //Update Contact
            if ($groupProducts && $groupProducts->count()) {
                $result = CRest::call('crm.deal.productrows.set', ['id' => $params->dealId, 'rows' => $groupProducts->toArray()]);
                //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
                usleep(600000);
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::syncInvoicesToBitrix Failed ".json_encode($e->getMessage()));
        }
    }
}
