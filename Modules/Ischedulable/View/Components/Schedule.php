<?php

namespace Modules\Ischedulable\View\Components;

use Illuminate\View\Component;

class Schedule extends Component
{
  public $view;
  public $layout;
  public $item;
  public $groupSchedule;
  public $formatHour;
  public $symbolToUniteDays;
  public $symbolToUniteHours;
  public $title;
  public $description;
  public $withTitle;
  public $withDescription;
  public $groupDays;
  public $withIcon;
  public $icon;
  public $colorIcon;
  public $colorNameDay;
  public $colorHours;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($view = null, $layout = 'schedule-layout-1', $item = null, $groupDays = true,
                              $formatHour = null, $symbolToUniteDays = 'a', $symbolToUniteHours = 'a',
                              $title = 'Horarios De Atención', $description = null, $withTitle = false,
                              $withDescription = false, $withIcon = false, $icon = "fa-regular fa-clock",
                              $colorIcon = '', $colorNameDay = '', $colorHours = '')
  {
    $this->item = $item ?? json_decode(setting('ischedulable::siteSchedule')) ?? [];
    $this->item->workTimes = (collect($this->item->workTimes));
    if (is_null($item) && !is_null(json_decode(setting('ischedulable::siteSchedule')))) {
      $this->item->workTimes = $this->item->workTimes->sortBy("dayId");
    } else {
      $this->item->workTimes = $this->item->workTimes->sortBy("day_id");
    }
    $this->layout = $layout;
    $this->view = $view ?? "ischedulable::frontend.components.schedule.layouts.{$this->layout}.index";
    $this->formatHour = $formatHour ?? 'g:i a';
    $this->symbolToUniteDays = $symbolToUniteDays;
    $this->symbolToUniteHours = $symbolToUniteHours;
    $this->title = $title;
    $this->description = $description;
    $this->withTitle = $withTitle;
    $this->withDescription = $withDescription;
    $this->groupDays = $groupDays;
    $this->withIcon = $withIcon;
    $this->icon = $icon;
    $this->colorIcon = $colorIcon;
    $this->colorNameDay = $colorNameDay;
    $this->colorHours = $colorHours;

    $groupedDays = [];
    $dayGroup = null;

    if (isset($this->item->workTimes)) {
      foreach ($this->item->workTimes as $day) {
        $dateOpen = strtotime($day->startTime ?? $day->start_time);
        $openHour = date($this->formatHour, $dateOpen);
        $dateClose = strtotime($day->endTime ?? $day->end_time);
        $closeHour = date($this->formatHour, $dateClose);
        $currentDay = $day->dayId ?? $day->day_id;

        if ($dayGroup == null) {
          $dayGroup = [
            'minDay' => $currentDay,
            'maxDay' => $currentDay,
            'openHour' => $openHour,
            'closeHour' => $closeHour,
          ];
        } elseif ($openHour == $dayGroup['openHour'] && $closeHour == $dayGroup['closeHour'] && $currentDay == ($dayGroup['maxDay'] + 1)) {
          $dayGroup['maxDay'] = $currentDay;
        } else {
          $groupedDays[] = $dayGroup;
          $dayGroup = [
            'minDay' => $currentDay,
            'maxDay' => $currentDay,
            'openHour' => $openHour,
            'closeHour' => $closeHour,
          ];
        }
      }
      if ($dayGroup != null) {
        $groupedDays[] = $dayGroup;
      }
    }

    usort($groupedDays, function ($a, $b) {
      return $a['minDay'] - $b['minDay'];
    });

    $dayTranslations = [
      '1' => trans('ischedulable::common.day.monday'),
      '2' => trans('ischedulable::common.day.tuesday'),
      '3' => trans('ischedulable::common.day.wednesday'),
      '4' => trans('ischedulable::common.day.thursday'),
      '5' => trans('ischedulable::common.day.friday'),
      '6' => trans('ischedulable::common.day.saturday'),
      '7' => trans('ischedulable::common.day.sunday'),
    ];

    foreach ($groupedDays as &$days) {
      $days['minDay'] = $dayTranslations[$days['minDay']];
      $days['maxDay'] = $dayTranslations[$days['maxDay']];
    }
    $this->groupSchedule = $groupedDays;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view($this->view);
  }
}