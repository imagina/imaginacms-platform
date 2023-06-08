<?php

namespace Modules\Ibooking\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ResourceTransformer extends CrudResource
{

  public function modelAttributes($request)
  {

    $data = [];

    $filter = json_decode($request->filter);
    if (isset($filter->withMeetingConfig) && isset($this->options->email)) {
      $data['meetingConfig'] = $this->validateMeetingRequirements([
        'meetingConfig' => [
          'providerName' => $filter->withMeetingConfig,
          'email' => $this->options->email ?? null
        ]
      ]);
    }

    return $data;

  }

}
