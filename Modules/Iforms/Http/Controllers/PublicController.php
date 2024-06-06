<?php

namespace Modules\Iforms\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iforms\Entities\Lead;
use Modules\Iforms\Http\Requests\CreateLeadRequest;
use Modules\Iforms\Repositories\FieldRepository;
use Modules\Iforms\Repositories\FormRepository;
use Modules\Setting\Contracts\Setting;
use Request;

class PublicController extends BasePublicController
{

    private $lead;

    /**
     * @var Application
     */
    private $app;
    private $form;
    private $setting;
    private $field;

    public function __construct(Application $app, Setting $setting, FieldRepository $field, FormRepository $form)
    {
        parent::__construct();
        $this->app = $app;
        $this->setting = $setting;
        $this->field = $field;
        $this->form = $form;

    }


    public function store(CreateLeadRequest $request)
    {

        $data=$request->all();
        $response = array();
        $response['status'] = 'error'; //default
        $response['data'] = array(); //default

        try {
            $data = Request::all();

            $form = $this->form->find($data['form_id']);
            if (empty($form->id)) {
                throw new \Exception(trans('iforms::common.forms_not_found'));
            }
            $attr = array();
            $attr['form_id'] = $form->id;
            $attr['options'] = array();

            foreach ($this->fields as $field) {

                if (!empty($field->name) && !empty($data[$field['name']])) {
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

            if ($response['status'] == "fail") {
                return response()->json($response);
            }


            $attr['options'] = json_encode($attr['options']);

            $this->lead->create($attr);

            /**
             * Send email
             */

            $emails = explode(',', $this->setting->get('iforms::form-emails'));
            if (isset($form->options->destination_email) && !empty($form->options->destination_email)) {
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

}
