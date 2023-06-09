<?php

namespace Modules\Imeeting\Traits;

use Modules\Imeeting\Entities\Meeting;

/**
 * Trait to check and validate requirements
 * Used in : Ibooking-Resource, Ibooking-ResourceTransformer
 */
trait Meetingable
{
    /**
     * Boot trait method
     */
    public static function bootMeetingable()
    {
        //Listen event after create model
        static::createdWithBindings(function ($model) {
            $model->checkMeetingRequirements($model->getEventBindings('createdWithBindings'));
        });

        static::updatedWithBindings(function ($model) {
            $model->checkMeetingRequirements($model->getEventBindings('updatedWithBindings'));
        });
    }

    /**
     * Check Meeting Requirements when a model is created or updated
     * Case Zoom: It is necessary to have a zoom user for the meeting
     */
    public function checkMeetingRequirements($params)
    {
        \Log::info('Imeeting: Traits|Meetingable|CheckMeetingRequirements');

        if (isset($params['data']['meeting_config'])) {
            $meetingConfig = $params['data']['meeting_config'];

            if (isset($meetingConfig['provider_name'])) {
                //Provider Service
                $service = app('Modules\Imeeting\Services\\'.ucfirst($meetingConfig['provider_name']).'Service');

                try {
                    $response = $service->checkRequirements($meetingConfig);
                } catch (\Exception $e) {
                    $status = 500;
                    $response = [
                        'errors' => $e->getMessage(),
                    ];
                    \Log::error('Imeeting: Traits|Meetingable|CheckMeetingRequirements|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
                }
            }
        }
    }

    /**
     * Validations in Provider Meetings
     * Case Zoom: User must be "verified" to create a meeting
     *
     * @param meetingConfig - providerName
     * @param meetingConfig - email
     */
    public function validateMeetingRequirements($params)
    {
        \Log::info('Imeeting: Traits|Meetingable|ValidateMeetingRequirements');

        $meetingConfig = $params['meetingConfig'];

        if (isset($meetingConfig['providerName'])) {
            //Provider Service
            $service = app('Modules\Imeeting\Services\\'.ucfirst($meetingConfig['providerName']).'Service');

            try {
                $responseService = $service->validateRequirements($meetingConfig);

                $response = array_merge([
                    'email' => $meetingConfig['email'],
                    'providerName' => $meetingConfig['providerName'],
                ], $responseService);
            } catch (\Exception $e) {
                $status = 500;
                $response = [
                    'errors' => $e->getMessage(),
                ];
                \Log::error('Imeeting: Traits|Meetingable|ValidateMeetingRequirements|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
            }
        }

        return $response;
    }
}
