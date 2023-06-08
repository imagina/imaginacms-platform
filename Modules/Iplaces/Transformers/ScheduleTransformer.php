<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 13/11/2018
 * Time: 10:16 AM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;


class ScheduleTransformer extends JsonResource
{

  public function toArray($request)
  {
    $data = [
      'id' => $this->when(isset($this->id),$this->id),
      'title' => $this->when(isset($this->title),$this->title),
      'fromDay' => $this->when(isset($this->from_day),$this->from_day),
      'untilDay' => $this->when(isset($this->until_day),$this->until_day),
      'fromTime' => $this->when(isset($this->from_time),$this->from_time),
      'untilTime' => $this->when(isset($this->until_time),$this->until_time),
      'options' => $this->when(isset($this->options),$this->options),
      'createdAt' => $this->when(isset($this->created_at),$this->created_at),
      'updatedAt' => $this->when(isset($this->updated_at),$this->updated_at),
    ];
    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';

      }
    }

    return $data;

  }


}
