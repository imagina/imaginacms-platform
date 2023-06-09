<?php

namespace Modules\Requestable\Services;

use Illuminate\Http\Request;
use Modules\Icomments\Services\CommentService;
use Modules\Iforms\Events\SyncFormeable;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Requestable\Entities\DefaultStatus;
use Modules\Requestable\Http\Controllers\Api\FieldApiController;
use Modules\Requestable\Repositories\CategoryRepository;
use Modules\Requestable\Repositories\RequestableRepository;
use Modules\Requestable\Repositories\StatusRepository;

class RequestableService extends BaseApiController
{
    private $field;

    private $category;

    private $commentService;

    private $requestableRepository;

    private $statusRepository;

    public function __construct(
    RequestableRepository $requestableRepository,
    FieldApiController $field,
    CategoryRepository $category,
    CommentService $commentService,
    StatusRepository $statusRepository
  ) {
        $this->requestableRepository = $requestableRepository;
        $this->field = $field;
        $this->category = $category;
        $this->commentService = $commentService;
        $this->statusRepository = $statusRepository;
    }

    public function create($data)
    {
        if (isset($data['category_id']) && ! empty($data['category_id'])) {
            $params = [
                'include' => [],
                'fields' => [],
            ];
            $category = $this->category->getItem($data['category_id'], json_decode(json_encode($params)));
        } else {
            $params = [
                'filter' => [
                    'field' => 'type',
                ],
                'include' => [],
                'fields' => [],
            ];
            $category = $this->category->getItem($data['type'], json_decode(json_encode($params)));
        }

        if (! isset($category->id)) {
            throw new \Exception('Request Type not found', 400);
        }

        $data['type'] = $category->type;
        $eventPath = $category->events['create'] ?? null;

        $data['status_id'] = isset($data['status_id']) ? $data['status_id'] : $category->defaultStatus()->id;
        $data['requestable_type'] = $category->requestable_type;
        $data['category_id'] = $category->id;

        if ($data['requestable_type'] == "Modules\User\Entities\Sentinel\User") {
            $data['requestable_id'] = $data['requestable_id'] ?? \Auth::id() ?? null;
        }

        //Create item
        $model = $this->requestableRepository->create($data);

        if ($model && $eventPath) {
            event($event = new $eventPath($model));
        }

        return $model;
    }

    public function update($criteria, $data, $params = null)
    {
        //Request to Repository
        $oldRequest = $this->requestableRepository->getItem($criteria, $params);

        if (! isset($oldRequest->id)) {
            throw new \Exception('Item not found', 404);
        }

        $data['type'] = $oldRequest->type;

        //getting update request config
        $category = $oldRequest->category;

        //if the data has status will be take it in the value of the category statuses
        //else the status will be take it of the id of the category statuses
        if (isset($data['status'])) {
            $status = $category->statuses->where('value', $data['status'])->first();
        } else {
            $status = $category->statuses->where('id', $data['status_id'])->first();
        }

        //check if the request need to be deleted or just updated because some statuses could need to delete the request
        [$response, $newRequest] = $this->updateOrDelete($criteria, $data, $status ?? null, $oldRequest);

        //if the status it's updating
        if (isset($data['status']) || isset($data['status_id'])) {
            //replacing to the real status id
            $data['status_id'] = $status->id;
            //if the status it's different of the old status in the request, will be dispatch the status event if exist
            if ($oldRequest->status_id != $status->id) {
                //default status updated comment
                $this->commentService->create($oldRequest, ['internal' => true, 'comment' => trans('requestable::statuses.comments.statusUpdated', ['prevStatus' => $oldRequest->status->title, 'postStatus' => $status->title])]);

                //custom comment to the status updated
                if (isset($data['comment']) && ! empty($data['comment'])) {
                    $this->commentService->create($oldRequest, ['comment' => $data['comment']]);
                }

                if (! empty($status->events)) {
                    $eventStatusPaths = ! is_array($status->events) ? [$status->events] : $status->events;

                    foreach ($eventStatusPaths as $eventStatusPath) {
                        event(new $eventStatusPath($newRequest, $oldRequest, $oldRequest->createdByUser));
                    }
                }
            }
        }

        // checking eta
        if (isset($data['eta'])) {
            //if the eta it's different of the old eta the event will be dispatched
            if ($oldRequest->eta != $data['eta']) {
                $eventETAPath = $category->events['etaUpdated'] ?? null;

                if ($eventETAPath) {
                    event(new $eventETAPath($newRequest, $oldRequest));
                }
            }
        }

        //finding create event
        $eventPath = $category->events['update'] ?? null;

        //request update event
        if ($eventPath) {
            event(new $eventPath($newRequest, $oldRequest));
        }

        return $newRequest;
    }

    private function updateOrDelete($criteria, $data, $status = null, $oldRequest = null)
    {
        //Get Parameters from URL.
        $params = $this->getParamsRequest(request());
        // if must be deleted

        //Request to Repository
        $newRequest = $this->requestableRepository->updateBy($criteria, $data);
        $response = ['data' => 'Item Updated'];

        if (isset($status->delete_request) && $status->delete_request) {
            $permission = $params->permissions['requestable.requestables.destroy'] ?? false;

            // solo se permite borrar request si:
            // se tiene el permiso para eliminar requests
            // o que el request haya sido creado por el user que está autenticado
            if ($permission || \Auth::id() == $oldRequest->created_by) {
                //call Method delete
                $this->requestableRepository->deleteBy($criteria, $params);

                $deletedEvent = $oldRequest->category->events['delete'] ?? null;

                if ($deletedEvent) {
                    event(new $deletedEvent($newRequest, $oldRequest));
                }

                $response = ['data' => 'Item Deleted'];
                $newRequest = null;
            } else {
                throw new \Exception('Permission denied', 401);
            }
        }

        return [
            $response,
            $newRequest,
        ];
    }

    /**
     * Create Category, sync with Form, create statuses
     *
     * @param Config - Check README.MD to params config
     */
    public function createFromConfig($config)
    {
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

        $params = [
            'filter' => ['field' => 'type'],
            'include' => [],
            'fields' => [],
        ];

        if (isset($config['type'])) {
            $category = $this->category->getItem($config['type'] ?? '', json_decode(json_encode($params)));

            if (! isset($category->id)) {
                try {
                    //Create Category
                    $category = $this->category->create([
                        'type' => $config['type'],
                        'time_elapsed_to_cancel' => $config['timeElapsedToCancel'] ?? -1,
                        'events' => $config['events'] ?? null,
                        'internal' => $config['internal'] ?? 1,
                        'requestable_type' => $config['requestableType'] ?? null,
                        $locale => [
                            'title' => trans($config['title']),
                        ],
                    ]);

                    //Sync Formeable
                    if (isset($config['formId']) && ! empty($config['formId'])) {
                        event(new SyncFormeable($category, ['form_id' => is_int($config['formId']) ? $config['formId'] : setting($config['formId'], null, null)]));
                    }

                    // Add default Statuses
                    if (isset($config['useDefaultStatuses']) && $config['useDefaultStatuses']) {
                        $statuses = (new DefaultStatus())->lists();
                    } else {
                        $statuses = $config['statuses'];
                    }

                    // Create Status
                    foreach ($statuses as $key => $status) {
                        $this->statusRepository->create([
                            'category_id' => $category->id,
                            'value' => $key,
                            'final' => $status['final'] ?? false,
                            'default' => $config['defaultStatus'] ?? $status['default'] ?? false,
                            'cancelled_elapsed_time' => $config['statusToSetWhenElapsedTime'] ?? $status['cancelled_elapsed_time'] ?? false,
                            'events' => $config['eventsWhenStatus'][$key] ?? $status['events'] ?? null,
                            'delete_request' => $config['deleteWhenStatus'][$key] ?? $status['delete_request'] ?? false,
                            $locale => [
                                'title' => trans($status['title']),
                            ],
                        ]
                        );
                    }
                } catch(\Exception $e) {
                    \Log::error('Requestable: Services|RequestableService|createFromConfig|Message: '.$e->getMessage());
                    dd($e);
                }
            }
        }
    }

    public function validateCreatedBy(array $data, object $params)
    {
        if (isset($data['created_by'])) {
            if (! isset($params->permissions['requestable.requestables.edit-created-by']) || ! $params->permissions['requestable.requestables.edit-created-by']) {
                unset($data['created_by']);
            }
        }

        return $data;
    }
}
