<?php

namespace Modules\Iforms\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iforms\Events\LeadWasCreated;
use Modules\Iforms\Http\Requests\CreateLeadRequest;
use Modules\Iforms\Repositories\FormRepository;
use Modules\Iforms\Repositories\LeadRepository;
use Modules\Iforms\Services\LeadsExportService;
use Modules\Iforms\Transformers\LeadTransformer;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Validators\AvailableExtensionsRule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// Base Api

// Transformers

// Repositories

// Export

class LeadApiController extends BaseApiController
{
    private $lead;

    private $form;

    public function __construct(LeadRepository $lead, FormRepository $form)
    {
        $this->lead = $lead;
        $this->form = $form;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $data = $this->lead->getItemsBy($params);

            if (isset($params->filter->export) && $params->filter->export == true) {
                $LeadsExportService = new LeadsExportService();

                return $LeadsExportService->exportFile($data);
            }

            //Response
            $response = ['data' => LeadTransformer::collection($data)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($data)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $data = $this->lead->getItem($criteria, $params);
            //Break if no found item
            if (! $data) {
                throw new Exception('Item not found', 204);
            }
            //Response
            $response = ['data' => new LeadTransformer($data)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($data)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->all() ?? []; //Get data

            $form = $this->form->find($data['form_id']);
            if (empty($form->id)) {
                throw new \Exception(trans('iforms::common.forms_not_found'));
            }

            $this->validateRequestApi(new CreateLeadRequest($data));

            $attr = [];
            $attr['form'] = $form;
            $attr['form_id'] = $form->id;
            $attr['organization_id'] = $form->organization_id ?? null;
            $attr['values'] = [];
            $fields = $form->fields;
            $attr['reply'] = [['address' => env('MAIL_FROM_ADDRESS'), 'email' => env('MAIL_FROM_ADDRESS'), 'name' => 'Client']];

            //find the reply To email field value
            if (isset($form->options->replyTo) && ! empty($form->options->replyTo)) {
                $replyToField = $fields->where('id', $form->options->replyTo)->first();

                if (isset($replyToField->id)) {
                    if (isset($data[$replyToField->name]) && ! empty($data[$replyToField->name])) {
                        $attr['reply'][0]['address'] = $data[$replyToField->name];
                        $attr['reply'][0]['email'] = $data[$replyToField->name];
                        $attr['reply'][0]['name'] = $data[$replyToField->name]; //This is just in case when the name is not defined
                    }
                }
            }

            //find the reply To name field value
            if (isset($form->options->replyToName) && ! empty($form->options->replyToName)) {
                $replyToNameField = $fields->where('id', $form->options->replyToName)->first();

                if (isset($replyToNameField->id)) {
                    if (isset($data[$replyToNameField->name]) && ! empty($data[$replyToNameField->name])) {
                        $attr['reply'][0]['name'] = $data[$replyToNameField->name];
                    }
                }
            }

            foreach ($fields as $field) {
                //If field it's type FILE
                if ($field->type == 12) {
                    $this->saveAttachment($form, $field, $data, $attr, $data[$field->name]);
                }
                $attr['values'][$field->name] = $data[$field->name] ?? null;
            }

            //Create item
            $lead = $this->lead->create($attr);

            foreach ($fields as $field) {
                //If field its type FILE
                if ($field->type == 12) {
                    $this->replaceAttachmentPath($data, $form, $lead, $field, $attr['values'][$field->name]);
                }
                $attr['values'][$field->name] = $data[$field->name] ?? null;
            }

            //update the Lead with the Values parsed
            $lead = $this->lead->updateBy($lead->id, $attr);

            event(new  LeadWasCreated($lead, $attr));

            //Response
            $response = ['data' => $form->success_text ?? trans('iforms::leads.messages.message sent successfully')];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

//Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Update the specified lead in storage.
     *
     * @return Response
     */
    public function update($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);

            $data = $request->input('attributes');

            $lead = $this->lead->getItem($criteria, $params);

            $attr = [];
            $updateMedia = false;

            if (isset($data['assigned_to_id'])) {
                $attr['assigned_to_id'] = $data['assigned_to_id'];
            }

            if (isset($data['form_id'])) {
                $form = $this->form->find($data['form_id']);

                if (isset($form->id)) {
                    $attr['form'] = $form;
                    $attr['form_id'] = $form->id;
                    $attr['values'] = [];
                    $attr['reply'] = ['to' => env('MAIL_FROM_ADDRESS'), 'toName' => 'Client'];

                    $fields = $form->fields;
                    foreach ($fields as $field) {
                        //If field it's type FILE
                        if ($field->type == 12) {
                            if (is_file($data[$field->name])) {
                                $updateMedia = true;
                                $this->saveAttachment($form, $field, $data, $attr, $data[$field->name]);
                                $this->replaceAttachmentPath($data, $form, $lead, $field, $data[$field->name]);
                            }
                        }
                        $attr['values'][$field->name] = $data[$field->name] ?? null;
                    }
                }
            }

            //Update data
            $newData = $this->lead->update($lead, $attr);
            if ($updateMedia) {
                event(new UpdateMedia($lead, $data));
            }
            //Response
            //Response
            $response = ['data' => trans('iforms::leads.messages.message sent successfully')];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified lead from storage.
     *
     * @return Response
     */
    public function delete($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);
            //Delete data
            $entity = $this->lead->getItem($criteria, $params);
            $this->lead->destroy($entity);
            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    private function saveAttachment($form, $field, &$data, &$attr, UploadedFile $file)
    {
        $fileService = app('Modules\Media\Services\FileService');

        //validating the availableExtensions in the field if exist and not empty
        if (isset($field->rules->mimes) && ! empty(isset($field->rules->mimes))) {
            //extending the AvailableExtensionsRule in the Media Module, customizing the extensions and message
            $availableExtensionsRule = new AvailableExtensionsRule($field->rules->mimes, trans('iforms::leads.messages.invalidFileExtension', ['fieldLabel' => $field->label]));

            //getting the file extension
            $extension = FileHelper::getExtension($file->getClientOriginalName());

            if (! $availableExtensionsRule->passes($field->label, \Str::replace('.', '', $extension))) {
                throw new \Exception(json_encode(['errors' => [$availableExtensionsRule->message()]]), 400);
            }
        }

        //initializing medias_single attribute
        if (! isset($attr['medias_single'])) {
            $attr['medias_single'] = [];
        }

        //saving file in with Media FileService
        $file = $fileService->store($data[$field->name], 0, 'public', false);

        //merging all medias single in the form
        $attr['medias_single'] = array_merge($attr['medias_single'], [$form->system_name.$field->name.$field->id => $file->id]);

        //file token
        $token = $file->generateToken(setting('iforms::formFileTokenExpirationTime'));

        //replacing Object binary file with the file Id
        $data[$field->name] = $token->token;
    }

    private function replaceAttachmentPath(&$data, $form, $lead, $field, $token = '')
    {
        //replacing the attachment value with the relative path of the Iform PublicController
        $data[$field->name] = \URL::route('iform.lead.attachment', ['formId' => $form->id, 'leadId' => $lead->id, 'fileZone' => $form->system_name.$field->name.$field->id], false).'?token='.$token;
    }
}
