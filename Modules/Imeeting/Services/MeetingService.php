<?php

namespace Modules\Imeeting\Services;

// Repositories
use Modules\Imeeting\Repositories\MeetingRepository;

class MeetingService
{
    private $meeting;

    public function __construct(MeetingRepository $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * @param array meetingAttr (title,startTime,email, etc)
     * @param array entityAttr (id,type)
     * @param string provider (optional)
     */
    public function create($data)
    {
        // Default Provider
        $providerName = 'zoom';

        // check other provider (if exist)
        if (isset($data['providerName'])) {
            $providerName = $data['providerName'];
        }

        //Provider Service
        $service = app('Modules\Imeeting\Services\\'.ucfirst($providerName).'Service');

        try {
            // Create Meeting in the Provider
            $meetingDataProvider = $service->create($data);

            // Validate Error Provider
            if (isset($meetingDataProvider['errors'])) {
                throw new \Exception($meetingDataProvider['errors'], 500);
            }

            // Add entities attributes from request
            $meetingDataProvider['entity_id'] = $data['entityAttr']['id'];
            $meetingDataProvider['entity_type'] = $data['entityAttr']['type'];

            //Create meeting in Module
            $response = $this->meeting->create($meetingDataProvider);
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];

            \Log::error('Module Imeeting: Service Meeting - Create: '.$e->getMessage());
        }

      return $response;
    }
}
