<?php

namespace Modules\Iforms\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Iforms\Http\Requests\CreateLeadRequest;
use Modules\Iforms\Repositories\FieldRepository;
use Modules\Iforms\Repositories\FormRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Setting\Contracts\Setting;

class PublicController extends BaseApiController
{
    private $lead;

    /**
     * @var Application
     */
    private $app;

    private $form;

    private $setting;

    private $field;

    private $leadRepository;

    public function __construct(Application $app, Setting $setting, FieldRepository $field, FormRepository $form)
    {
        parent::__construct();
        $this->app = $app;
        $this->setting = $setting;
        $this->field = $field;
        $this->form = $form;
        $this->leadRepository = app('Modules\Iforms\Repositories\LeadRepository');
    }

    public function store(CreateLeadRequest $request)
    {
        $data = $request->all();
        $response = [];
        $response['status'] = 'error'; //default
        $response['data'] = []; //default

        try {
            $data = Request::all();

            $form = $this->form->find($data['form_id']);
            if (empty($form->id)) {
                throw new \Exception(trans('iforms::common.forms_not_found'));
            }
            $attr = [];
            $attr['form_id'] = $form->id;
            $attr['options'] = [];

            foreach ($this->fields as $field) {
                if (! empty($field->name) && ! empty($data[$field['name']])) {
                    if ($field->name == 'email') {
                        $replyto = $data['email'];
                    } else {
                        $replyto = env('MAIL_FROM_ADDRESS');
                    }
                    if ($field['name'] == 'name') {
                        $replytoname = $data['name'];
                    } else {
                        $replytoname = 'Client';
                    }

                    $attr['options'][$field['name']] = $data[$field['name']];
                }
            }

            //TODO: Verify required parameters here.

            if ($response['status'] == 'fail') {
                return response()->json($response);
            }

            $attr['options'] = json_encode($attr['options']);

            $this->lead->create($attr);

            /**
             * Send email
             */
            $emails = explode(',', $this->setting->get('iforms::form-emails'));
            if (isset($form->options->destination_email) && ! empty($form->options->destination_email)) {
                array_push($emails, $form->options->destination_email);
            }

            $from = $this->setting->get('iforms::from-email');
            if (empty($from)) {
                $from = env('MAIL_FROM_ADDRESS');
            }
            $sender = $this->setting->get('core::site-name');
            $title = $this->form->title;
            Mail::send(['iforms::frontend.emails.form', 'iforms::frontend.emails.textform'],
                [
                    'data' => $data,
                    'form' => $this->form,
                ], function ($message) use ($emails, $sender, $title, $from, $replyto, $replytoname) {
                    $message->to($emails, $sender)
                      ->replyTo($replyto, $replytoname)
                      ->from($from, $sender)
                      ->subject($title);
                });

            $response['status'] = 'success';
            //$response['message'] = '';
        } catch (\Exception $t) {
            //var_dump($t);
            $response['status'] = 'error';
            $response['message'] = $t->getMessage();
            Log::error($response);
        }

        return response()->json($response);
    }

    public function getAttachment(Request $request, $formId, $leadId, $fileZone)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $lead = $this->leadRepository->getItem($leadId, $params);

            //Request to Repository
            $form = $this->form->getItem($formId, $params);

            if (! isset($lead->id) || ! isset($form->id)) {
                throw new Exception('Item not found', 404);
            }

            $attachment = $lead->filesByZone($fileZone)->first();

            $type = $attachment['mimetype'] ?? null;

            //user authentication or token validation
            if (empty(\Auth::id())) {
                $token = $request->input('token');
                if (empty($token) || ! $attachment->validateToken($token)) {
                    return redirect()->route(config('asgard.user.config.redirect_route_not_logged_in'));
                }
            }

            $privateDisk = config('filesystems.disks.public');
            $mediaFilesPath = config('asgard.media.config.files-path');

            $path = $privateDisk['root'].$mediaFilesPath.$attachment->filename;

            return response()->file($path, [
                'Content-Type' => $type,
            ]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function viewForm(Request $request, $formId)
    {
        try {
            $params = $request->all();
            $formElementId = $params['formElementId'] ?? null;

            return view('iforms::frontend.index', compact('formId', 'formElementId'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function renderJsForm(Request $request, $formId)
    {
        $params = $request->all();
        //Instance the file URL
        $fileUrl = asset('modules/iforms/Render/formFrame.js');
        //Get file
        $jsString = file_get_contents($fileUrl);
        //Replace form id
        $jsString = str_replace('{formId}', str_replace('.js', '', $formId), $jsString);
        $jsString = str_replace('{iframeId}', ($params['iframeId'] ?? uniqid()), $jsString);
        $jsString = str_replace('{domainUrl}', url('iforms/view'), $jsString);
        //Return file
        return response($jsString)->header('Content-Type', 'application/javascript');
    }
}
