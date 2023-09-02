<?php

namespace Modules\Iwhmcs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetClientToInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logTitle = '[IWHMCS]::JOB SetClientToInvoices';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->assignFromProjects();
        $this->assignByClientIdToWebProduct();
        $this->assignByClientIdToProduct();
    }

    //Assign by project invoice id
    private function assignFromProjects()
    {
        try {
            //Get clients without group
            $projectInvoices = \DB::connection('whmcs')->table('mod_project')->whereNotNull('invoiceids')->get();

            //Set Hosting to invoice
            foreach ($projectInvoices as $index => $project) {
                $invoiceItemsCount = 0; //Counter to invoice items

                foreach (explode(',', $project->invoiceids) as $invoiceId) {
                    //Get invoices items
                    $invoiceItems = \DB::connection('whmcs')->table('tblinvoiceitems')->where('invoiceid', $invoiceId)
                      ->whereNotIn('type', ['AddFunds', 'Invoice'])
                      ->where(function ($q) {
                          $q->whereNull('relid')->orWhere('relid', '=', '0')->orWhere('relid', '=', '');
                      })->get();

                    //Sum to invoices items counter
                    $invoiceItemsCount += $invoiceItems->count();

                    //Set project id to invoice item
                    foreach ($invoiceItems as $invoiceItem) {
                        \DB::connection('whmcs')->table('tblinvoiceitems')->where('id', $invoiceItem->id)->update([
                            'type' => 'Hosting',
                            'relid' => $project->service_id,
                        ]);
                    }
                }

                //Log
                \Log::info("{$this->logTitle}::assignFromProjects | {$invoiceItemsCount} Invoice Items | ({$index}/{$projectInvoices->count()})");
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::assignFromProjects failed ".json_encode($e->getMessage()));
        }
    }

    //Assign by client id to we product
    private function assignByClientIdToWebProduct()
    {
        try {
            //Get clients without group
            $invoiceItems = \DB::connection('whmcs')->select(\DB::raw("
        SELECT tblinvoiceitems.* FROM tblinvoiceitems 
        LEFT JOIN tblinvoices ON tblinvoices.id = tblinvoiceitems.invoiceid
        WHERE (relid is null or relid = '' or relid = 0)
        AND description NOT LIKE '%Hosting%'
        AND description NOT LIKE '%Reseller%'
        AND description NOT LIKE '%Dominio%'
        AND description NOT LIKE '%Consignacion%'
        AND description NOT LIKE '%VPS%'
        AND description NOT LIKE '%WHM%'
        AND amount >= 0
        AND tblinvoices.status='Paid'
        AND tblinvoiceitems.type not in ('AddFunds','Invoice')
      "));

            //Set Hosting to invoice
            foreach ($invoiceItems as $index => $invoiceItem) {
                //Get client web product
                $webProduct = \DB::connection('whmcs')->table('tblhosting')->where('userid', $invoiceItem->userid)
                  ->whereIn('packageId', [81, 82, 84, 85, 86, 87, 160, 330, 331, 332, 75, 76, 77, 333, 334, 335])
                  ->first();

                //Set project id to invoice item
                if ($webProduct) {
                    \DB::connection('whmcs')->table('tblinvoiceitems')->where('id', $invoiceItem->id)->update([
                        'type' => 'Hosting',
                        'relid' => $webProduct->id,
                    ]);
                    //Log
                    \Log::info("{$this->logTitle}::assignByClientIdToWebProduct ({$index}/".count($invoiceItems).')');
                } else {
                    //Log
                    \Log::info("{$this->logTitle}::assignByClientIdToWebProduct NOT FOUND PRODUCT ({$index}/".count($invoiceItems).')');
                }
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::assignByClientIdToWebProduct failed ".json_encode($e->getMessage()));
        }
    }

    //Assign by client id to product
    private function assignByClientIdToProduct()
    {
        try {
            //Get clients without group
            $invoiceItems = \DB::connection('whmcs')->select(\DB::raw("
        SELECT tblinvoiceitems.* FROM tblinvoiceitems 
        LEFT JOIN tblinvoices ON tblinvoices.id = tblinvoiceitems.invoiceid
        WHERE (relid is null or relid = '' or relid = 0)
        AND amount >= 0
        AND tblinvoices.status='Paid'
        AND tblinvoiceitems.type not in ('AddFunds','Invoice')
      "));

            //Set Hosting to invoice
            foreach ($invoiceItems as $index => $invoiceItem) {
                //Get client web product
                $webProduct = \DB::connection('whmcs')->table('tblhosting')->where('userid', $invoiceItem->userid)->first();

                //Set project id to invoice item
                if ($webProduct) {
                    \DB::connection('whmcs')->table('tblinvoiceitems')->where('id', $invoiceItem->id)->update([
                        'type' => 'Hosting',
                        'relid' => $webProduct->id,
                    ]);
                    //Log
                    \Log::info("{$this->logTitle}::assignByClientIdToProduct ({$index}/".count($invoiceItems).')');
                } else {
                    //Log
                    \Log::info("{$this->logTitle}::assignByClientIdToProduct NOT FOUND PRODUCT ({$index}/".count($invoiceItems).')');
                }
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle}::assignByClientIdToProduct failed ".json_encode($e->getMessage()));
        }
    }
}
