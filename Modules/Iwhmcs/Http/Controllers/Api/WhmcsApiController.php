<?php

namespace Modules\Iwhmcs\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
//Services
use Modules\Iwhmcs\Jobs\SetClientToInvoices;
//jobs
use Modules\Iwhmcs\Jobs\SetGroupToClients;
use Modules\Iwhmcs\Jobs\SyncClientsToBitrix24;
use Modules\Iwhmcs\Jobs\syncInvoicesByContactToBitrix;
use Modules\Iwhmcs\Jobs\syncProductsToBitrix;
use Modules\Iwhmcs\Jobs\syncProjectsAsHosting;
use Modules\Iwhmcs\Services\Bitrix24\CRest;

class WhmcsApiController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    //Sync clients to bitrix24
    public function syncClientsToBitrix24(Request $request)
    {
        try {
            //Dispatch job
            SyncClientsToBitrix24::dispatch()->onQueue('whmcsJob');
            //Response
            $response = ['data' => 'Job was created to sync clients in BITRIX24 from WHCMS'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    //Sync projects as hosting whcms-bitrix
    public function syncProjectsAsHosting(Request $request)
    {
        try {
            syncProjectsAsHosting::dispatch()->onQueue('whmcsJob');
            //Response
            $response = ['data' => 'Job was created to sync projects as hosting in WHCMS'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    //Set group to clients
    public function SetGroupClients(Request $request)
    {
        try {
            //Dispatch job
            SetGroupToClients::dispatch()->onQueue('whmcsJob');
            //Response
            $response = ['data' => 'Job was created to set group clients in WHCMS'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    //Set group to clients
    public function setClientToInvoice(Request $request)
    {
        try {
            //Dispatch job
            SetClientToInvoices::dispatch()->onQueue('whmcsJob');
            //Response
            $response = ['data' => 'Job was created to set client id to invoice items in WHCMS'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    //Set group to clients
    public function syncProductsToBitrix24(Request $request)
    {
        try {
            //Dispatch job
            syncProductsToBitrix::dispatch()->onQueue('whmcsJob');
            //Response
            $response = ['data' => 'Job was created to sync products with Bitrix24'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    //Set group to clients
    public function syncInvoicesToBitrix24(Request $request)
    {
        try {
            //Dispatch job
            syncInvoicesByContactToBitrix::dispatch()->onQueue('whmcsJob');
            //Response
            $response = ['data' => 'Job was created to sync invoices as deal on Bitrix24'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    //Weygo:: Validate deals after get client information
    public function weygoDealDataReceived(Request $request)
    {
        try {
            //Get attributes
            $attributes = $request->input('attributes') ?? [];
            if (! $attributes['email']) {
                throw new \Exception('Required "email" attributes', 404);
            }
            //Search contact on bitrix by email
            $contactsId = collect(CRest::call('crm.contact.list', [
                'filter' => ['EMAIL' => $attributes['email']],
                'select' => ['ID'],
            ])['result'])->pluck('ID')->toArray();
            if (! count($contactsId)) {
                throw new \Exception('Contact not found with this email', 404);
            }
            //Get deals
            $deals = CRest::call('crm.deal.list', [
                'filter' => [
                    'CATEGORY_ID' => 6,
                    'STAGE_ID' => 'C6:UC_6WQ6ZA', //Requirements
                ],
                'select' => ['TITLE', 'CONTACT_ID'],
            ])['result'];
            foreach ($deals as $deal) {
                if (in_array($deal['CONTACT_ID'], $contactsId)) {
                    CRest::call('crm.deal.update', [
                        'id' => $deal['ID'],
                        'fields' => ['STAGE_ID' => 'C6:NEW'],
                    ]);
                }
            }
            //Response
            $response = ['data' => 'Updated'];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
