<?php

namespace Modules\Iwhmcs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//Services
use Modules\Iwhmcs\Services\Bitrix24\CRest;

class syncDueInvoicesItemsToBitrix implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 5400;

    protected $logTitle;

    protected $filters;

    protected $dueItems;

    protected $clients;

    protected $relatedDueDeals;

    protected $tblOptType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logTitle = '[IWHMCS]::JOB syncDueInvoicesItemsToBitrix';
        $this->filters = (object) [
            'ignoredClients' => [1, 6],
            'dueRangeDate' => (object) [
                'from' => date('Y-m-d', strtotime('-20 day', strtotime(now()))),
                'to' => date('Y-m-d', strtotime('+5 day', strtotime(now()))),
            ],
            'ignoredInvoicesStatus' => ['Terminated', 'Cacelled', 'Fraud'],
            'allowedInvoicesItemTypes' => ['Hosting', 'Domain'],
        ];
        $this->tblOptType = 'bitrixDueDealInvoice';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //$this->removeDealsFromBitrix();
        //dd(CRest::call('crm.deal.get', ["id" => '94749', "select" => ["STAGE_ID"]]));
        //Call the due items
        $this->getDueItems();
        //Get the clients from all due information
        $this->getClients();
        //Get de related dueDeals
        $this->getRelatedDueDeals();

        //Create deals
        foreach ($this->dueItems as $index => $dueItem) {
            $dealBitrixId = $this->syncDueDeal($dueItem);
            \Log::info("{$this->logTitle}::syncDueDeal Success ".($index + 1).'/'.count($this->dueItems));
        }
    }

    /**
     * Get the due hostings
     */
    public function getDueItems()
    {
        try {
            //Get the invoices
            $invoices = \DB::connection('whmcs')->table('tblinvoices')
              ->select(
                  'tblinvoices.id',
                  'tblinvoices.userid',
                  'tblinvoices.duedate',
                  'tblinvoices.total as amount',
                  'tblinvoices.status',
                  'tblinvoices.updated_at'
              )
              ->whereNotIn('userid', $this->filters->ignoredClients)
              ->where(function ($q) {
                  $q->whereBetween('tblinvoices.duedate', [$this->filters->dueRangeDate->from, $this->filters->dueRangeDate->to])
                    ->orWhereBetween('tblinvoices.updated_at', [$this->filters->dueRangeDate->from, $this->filters->dueRangeDate->to]);
              })
              ->whereNotIn('status', $this->filters->ignoredInvoicesStatus)
              ->get()
              ->toArray();
            //Get the invoice items
            $invoicesItems = \DB::connection('whmcs')->table('tblinvoiceitems')
              ->select(
                  'tblinvoiceitems.*',
                  'tblhosting.packageid as productId',
                  'tblhosting.domain as hostingDomain',
                  'tbldomains.domain as tblDomain',
                  \DB::raw('IF(tblinvoiceitems.type = "Domain", tbldomains.domain, tblhosting.domain) as domain'),
                  'tblimoptions.value as bitrixProductId'
              )
              ->leftJoin('tblhosting', 'tblhosting.id', 'tblinvoiceitems.relid')
              ->leftJoin('tbldomains', 'tbldomains.id', 'tblinvoiceitems.relid')
              ->leftJoin('tblimoptions', function ($join) {
                  $join->on('tblimoptions.rel_id', 'tblhosting.packageid');
                  $join->on('tblimoptions.type', '=', \DB::raw("'bitrixProductId'"));
              })
              ->whereIn('tblinvoiceitems.type', $this->filters->allowedInvoicesItemTypes)
              ->whereIn('invoiceid', array_column($invoices, 'id'))
              ->get();
            //Group invoices items by invoice and get domain
            foreach ($invoices as $index => $invoice) {
                $invoices[$index]->products = $invoicesItems->where('invoiceid', $invoice->id)->toArray();
                //Get the domain. Search invoiceItem type domain or something else with domain
                $domain = $invoicesItems->where('invoiceid', $invoice->id)->where('type', 'Domain')->first();
                $domain = $domain ?? $invoicesItems->where('invoiceid', $invoice->id)->whereNotNull('domain')->first();
                $invoices[$index]->domain = $domain->domain ?? null;
            }
            //Set the due item and filter only the onvoices with items
            $this->dueItems = array_filter($invoices, function ($item) {
                return count($item->products);
            });
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::getDueHosting Failed ".json_encode($e->getMessage()));
        }
    }

    /**
     * Retur the clients data from an array of id
     *
     * @param $clientsId
     */
    public function getClients()
    {
        try {
            $this->clients = \DB::connection('whmcs')->table('tblclients')
              ->select('tblclients.*', 'tblimoptions.value as bitrixContactId')
              ->leftJoin('tblimoptions', function ($join) {
                  $join->on('tblimoptions.rel_id', 'tblclients.id');
                  $join->on('tblimoptions.type', '=', \DB::raw("'bitrixContactId'"));
              })
              ->whereNotIn('tblclients.id', $this->filters->ignoredClients)
              ->whereIn('tblclients.id', array_column($this->dueItems, 'userid'))
              ->get();
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::getClients Failed ".json_encode($e->getMessage()));
        }
    }

    /**
     * Get all relations between deals(bitrix) and hosting(whmcs)
     */
    public function getRelatedDueDeals()
    {
        try {
            $this->relatedDueDeals = \DB::connection('whmcs')->table('tblimoptions')
              ->where('type', $this->tblOptType)
              ->whereIn('rel_id', array_column($this->dueItems, 'id'))
              ->get();
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::getClients Failed ".json_encode($e->getMessage()));
        }
    }

    /**
     * Sync the due deal
     *
     * @param $type
     * @return mixed|string|void
     */
    public function syncDueDeal($deal)
    {
        try {
            //Instance dealId
            $dealId = null;
            //Instance the related billing status
            $billingStatus = [
                'Paid' => '961',
                'Unpaid' => '963',
                'Cancelled' => '975',
                'default' => '963',
            ];

            //Search rel with bitrix
            $dueDealBitrix = $this->relatedDueDeals
              ->where('rel_id', $deal->id)
              ->where('type', $this->tblOptType)
              ->first();

            //Get the client
            $client = $this->clients->where('id', $deal->userid)->first();

            //Map the deal data
            $dueDealData = [
                'ID' => $dueDealBitrix->value ?? null,
                'TITLE' => "{$deal->status}-{$deal->domain}",
                'CONTACT_ID' => $client->bitrixContactId,
                'OPENED' => 'Y',
                'CURRENCY_ID' => 'COP',
                'OPPORTUNITY' => $deal->amount,
                'UF_CRM_1679092607' => $deal->duedate, //DueDate
                //"UF_CRM_1679524104" => $billingCyle[$deal->billingcycle],//billing cycle
                'UF_CRM_1679524884' => $deal->domain, //Domain
                'UF_CRM_1679677439' => $billingStatus[$deal->status ?? 'default'] ?? $billingStatus['default'],
            ];

      //Sync deal
            if ($dueDealBitrix) {//Update Deal
                $result = CRest::call('crm.deal.update', ['id' => $dueDealData['ID'], 'fields' => $dueDealData]);
                //Set response
                $dealId = $dueDealData['ID'];
            } else {//Create Deal
                $result = CRest::call('crm.deal.add', ['fields' => array_merge($dueDealData, [
                    'STAGE_ID' => 'C17:NEW', //Pagos pendientes - WHMCS
                    'CATEGORY_ID' => '17', //Pagos pendientes - WHMCS
                ])]);
                //Save relation
                \DB::connection('whmcs')->table('tblimoptions')->insert([
                    'name' => $this->tblOptType,
                    'type' => $this->tblOptType,
                    'rel_id' => $deal->id,
                    'value' => $result['result'],
                ]);
                //Set response
                $dealId = $result['result'];
            }

            //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
            usleep(600000);

            //Set de product to deal
            if ($dealId) {
                //Instance the product data
                $dealProducts = [];
                foreach ($deal->products as $product) {
                    $dealProducts[] = [
                        'PRODUCT_ID' => $product->type == 'Domain' ? 863/*Dominio Registrado*/ :
                          ($product->bitrixProductId ?? 132/*hosting Linux Personal*/),
                        'PRICE' => $product->amount ?? 0,
                        'QUANTITY' => 1,
                    ];
                }
                //Set products to deal
                CRest::call('crm.deal.productrows.set', ['id' => $dealId, 'rows' => $dealProducts]);
                //update the opportunity of the deal
                CRest::call('crm.deal.update', ['id' => $dealId, 'fields' => $dueDealData]);
            }

            //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
            usleep(600000);
            //Response
            return $dealId;
        } catch (\Exception $e) {
            dd($e->getFile(), $e->getLine());
            \Log::info("{$this->logTitle}::syncDueDeal Failed ".json_encode($e->getMessage()));
        }
    }

    private function removeDealsFromBitrix()
    {
        //Get the reference
        $data = \DB::connection('whmcs')->table('tblimoptions')
          ->where('type', $this->tblOptType)
          //->take(500)
          ->get();

        //Remove deals
        foreach ($data as $index => $record) {
            $response = CRest::call('crm.deal.delete', ['id' => $record->value]);
            if (isset($response['result']) && $response['result']) {
                \DB::connection('whmcs')->table('tblimoptions')->where('id', $record->id)->delete();
            }
            \Log::info("{$this->logTitle}::removeDealsFromBitrix Success ".($index + 1).'/'.count($data).' ---> '.$record->id.' --> '.json_encode($response));
            //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
            usleep(300000);
        }
    }
}
