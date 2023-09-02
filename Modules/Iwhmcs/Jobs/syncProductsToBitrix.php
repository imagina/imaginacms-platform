<?php

namespace Modules\Iwhmcs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//Transformers
use Modules\Iwhmcs\Services\Bitrix24\CRest;
use Modules\Iwhmcs\Transformers\ProductGroupsToBitrix24Transformer;
//Services
use Modules\Iwhmcs\Transformers\ProductsToBitrix24Transformer;

class syncProductsToBitrix implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logTitle;

    protected $tblImOptionsTypeProducts;

    protected $tblImOptionsTypeProductsGroup;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logTitle = '[IWHMCS]::JOB syncProductsToBitrix';
        $this->tblImOptionsTypeProducts = 'bitrixProductId';
        $this->tblImOptionsTypeProductsGroup = 'bitrixProductGroupId';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //$this->syncProductGroupsToBitrix();
        $this->syncProductsToBitrix();
    }

    //Sync Clients to Bitrix
    public function syncProductGroupsToBitrix()
    {
        try {
            //Get WHMCS clients with contactBitrixId
            $productGroups = \DB::connection('whmcs')->table('tblproductgroups')
              ->select('tblproductgroups.*', \DB::raw(
                  "(SELECT value FROM tblimoptions WHERE rel_id = tblproductgroups.id and type = '{$this->tblImOptionsTypeProductsGroup}') as bitrixId"
              ))->get();

            //Transform clients to bitrix64
            $productSectionsBitrix = json_decode(json_encode(ProductGroupsToBitrix24Transformer::collection($productGroups)));

            foreach ($productSectionsBitrix as $index => $productSection) {
                //Update Contact
                if (isset($productSection->ID) && $productSection->ID) {
                    //Update Contact
                    $result = CRest::call('crm.productsection.update', ['id' => $productSection->ID, 'fields' => $productSection]);
                    //Log
                    \Log::info("{$this->logTitle}::syncProductGroupsToBitrix UPDATED (".($index + 1).'/'.count($productSectionsBitrix).')');
                } else {//Create contact
                    $result = CRest::call('crm.productsection.add', ['fields' => $productSection]);
                    //Save relation
                    if ($result && isset($result['result']) && $result['result']) {
                        \DB::connection('whmcs')->table('tblimoptions')->insert([
                            'name' => $this->tblImOptionsTypeProductsGroup,
                            'type' => $this->tblImOptionsTypeProductsGroup,
                            'rel_id' => $productSection->XML_ID,
                            'value' => $result['result'],
                        ]);
                    }
                    //Log
                    \Log::info("{$this->logTitle}::syncProductGroupsToBitrix CREATED (".($index + 1).'/'.count($productSectionsBitrix).')');
                }

                //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
                usleep(600000);
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::syncProductGroupsToBitrix Failed".json_encode($e->getMessage()));
        }
    }

    //Sync Clients to Bitrix
    public function syncProductsToBitrix()
    {
        try {
            //Get WHMCS clients with contactBitrixId
            $products = \DB::connection('whmcs')->table('tblproducts')
              ->select(
                  'tblproducts.*', 'tblproductgroups.name as groupName',
                  \DB::raw("(SELECT value FROM tblimoptions WHERE rel_id = tblproducts.id and type = '{$this->tblImOptionsTypeProducts}') as bitrixId"),
                  \DB::raw("(SELECT value FROM tblimoptions WHERE rel_id = tblproducts.gid and type = '{$this->tblImOptionsTypeProductsGroup}') as productSectionBitrixId"),
                  \DB::raw("(SELECT annually FROM tblpricing WHERE relid = tblproducts.id and type = 'product' and currency = 1) as copAnnuallyPrice"),
                  \DB::raw("(SELECT monthly FROM tblpricing WHERE relid = tblproducts.id and type = 'product' and currency = 1) as copMonthlyPrice"),
                  \DB::raw("(SELECT asetupfee FROM tblpricing WHERE relid = tblproducts.id and type = 'product' and currency = 1) as copSetupFeePrice"),
                  \DB::raw("(SELECT quarterly FROM tblpricing WHERE relid = tblproducts.id and type = 'product' and currency = 1) as copQuartelyPrice")
              )
              ->leftJoin('tblproductgroups', 'tblproductgroups.id', 'tblproducts.gid')
              ->get();

            //Transform clients to bitrix64
            $productsBitrix = json_decode(json_encode(ProductsToBitrix24Transformer::collection($products)));

            foreach ($productsBitrix as $index => $product) {
                //Update Contact
                if (isset($product->ID) && $product->ID) {
                    //Update Contact
                    $result = CRest::call('crm.product.update', ['id' => $product->ID, 'fields' => $product]);
                    //Log
                    \Log::info("{$this->logTitle}::syncProductsToBitrix UPDATED (".($index + 1).'/'.count($productsBitrix).')');
                } else {//Create contact
                    $result = CRest::call('crm.product.add', ['fields' => $product]);
                    //Save relation
                    if ($result && isset($result['result']) && $result['result']) {
                        \DB::connection('whmcs')->table('tblimoptions')->insert([
                            'name' => $this->tblImOptionsTypeProducts,
                            'type' => $this->tblImOptionsTypeProducts,
                            'rel_id' => $product->XML_ID,
                            'value' => $result['result'],
                        ]);
                    }
                    //Log
                    \Log::info("{$this->logTitle}::syncProductsToBitrix CREATED (".($index + 1).'/'.count($productsBitrix).')');
                }

                //Sleep by 0.6 seconds to prevent QUERY_LIMIT_EXCEEDED (2 by second)
                usleep(600000);
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::syncProductsToBitrix Failed".json_encode($e->getMessage()));
        }
    }
}
