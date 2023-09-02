<?php

namespace Modules\Imeeting\Traits;

trait MeetingableTransformer
{
    /**
     * Method to merge values with response
     */
    public function getDataMeetings()
    {
        $data = [
            'meetings' => $this->when($this->meetings, $this->meetings),
        ];

        return $data;
    }
}
