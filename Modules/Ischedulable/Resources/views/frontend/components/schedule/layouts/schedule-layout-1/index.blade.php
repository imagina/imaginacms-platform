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
          @foreach($groupSchedule as $schedule)
            <div class="schedule-day">
              <div class="day-schedule text-center">
                @if($withIcon)
                  <i class="{{$icon}} {{$colorIcon}}"></i>
                @endif
                @if($schedule['minDay'] == $schedule['maxDay'])
                  <p class="name-day {{$colorNameDay}}">
                    {{$schedule['minDay']}}
                  </p>
                @else
                  <p class="name-day {{$colorNameDay}}">
                    {{$schedule["minDay"]." ".$symbolToUniteDays." ".$schedule["maxDay"]}}
                  </p>
                @endif
              </div>
              <div class="hours-schedule {{$colorHours}} text-center pb-2">
                {{$schedule['openHour']." ".$symbolToUniteHours." ".$schedule['closeHour']}}
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
</div>