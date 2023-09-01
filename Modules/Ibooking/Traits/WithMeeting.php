<?php

namespace Modules\Ibooking\Traits;

use Modules\Ibooking\Events\ReservationWasCreated;
//Events
use Modules\Imeeting\Entities\Meeting;

/**
 * Trait to create a meeting with data from an entity
 * Used in : Ibooking - ReservationItem
 */
trait WithMeeting
{
    /**
     * Boot trait method
     */
    public static function bootWithMeeting()
    {
        // Validate Only Imeeting Enabled
        if (is_module_enabled('Imeeting')) {
            //Listen event after create model
            static::created(function ($model) {
                $model->createMeeting($model);
            });

            static::updated(function ($model) {
                $model->createMeeting($model);
            });
        }
    }

    /**
     * Create meeting to entity
     */
    public function createMeeting($model)
    {
        \Log::info('Ibooking: Traits|WithMeeting|CreateMeeting|WihtMeeting: '.$model->service->with_meeting.' ');

        // Validate Service With Meeting, Only Reservation Approved
        if (isset($model->service) && $model->service->with_meeting && $model->reservation->status == 1) {
            // Data Metting
            $dataToCreate['meetingAttr'] = [
                'title' => trans('ibooking::common.meeting.title').$model->reservation->customer->email,
                'startTime' => $model->start_date,
                'email' => $model->resource->options->email, //Host
            ];

            // Entity
            $dataToCreate['entityAttr'] = [
                'id' => $model->id,
                'type' => get_class($model),
            ];

            //\Log::info('Ibooking: Traits|WithMeeting|CreateMeeting|DataToCreate: '.json_encode($dataToCreate));

            // Create meeting with Provider
            $meeting = app('Modules\Imeeting\Services\MeetingService')->create($dataToCreate);

            if (isset($meeting['errors'])) {
                throw new \Exception($meeting['errors'], 500);
            } else {
                $extraParams['broadcastTo'] = [$model->reservation->customer->id, $model->resource->created_by];

                // Send Email and Notification Iadmin
                event(new ReservationWasCreated($model->reservation, $extraParams));
            }
        }
    }

    /*
    * Entity Relation with Meetings
    */
    public function meetings()
    {
        return $this->morphMany(Meeting::class, 'entity');
    }
}
