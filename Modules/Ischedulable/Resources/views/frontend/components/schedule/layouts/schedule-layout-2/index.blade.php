<div class="schedule schedule-layout-1 py-3">
  <div class="container">
    <div class="row">
      <div class="col-12">
        @if($withTitle)
          <div class="title-section py-3 text-center">
            {{$title}}
          </div>
        @endif
        @if($withDescription)
          <div class="description-section pb-3 text-center">
            {{$description}}
          </div>
        @endif
        @if (!is_null($groupSchedule))
          <div class="schedule-day">
            @foreach($groupSchedule as $schedule)
              <div class="day-schedule d-flex align-items-center pb-2">
                @if($withIcon)
                  <i class="{{$icon}} {{$colorIcon}} px-2"></i>
                @endif
                @if($schedule['minDay'] == $schedule['maxDay'])
                  <div class="name-day align-items-center {{$colorNameDay}}">
                    {{$schedule['minDay'].':'}}
                  </div>
                @else
                  <div  class="name-day align-items-center {{$colorNameDay}}">
                    {{$schedule["minDay"]." ".$symbolToUniteDays." ".$schedule["maxDay"].':'}}
                  </div>
                @endif
                <div class="hours-schedule {{$colorHours}} align-items-center px-2">
                  {{$schedule['openHour']." ".$symbolToUniteHours." ".$schedule['closeHour']}}
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</div>