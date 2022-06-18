<div id="timelineLayout2" class="timeline">

  <div class="entry">
    @foreach($items as $index => $item)
      <div class="content-timeline">
        <div class="title">
          <h3>
            <div class="date">
              {{$item->options->eventDate ?? ''}}
            </div>
            <div class="place font-weight-bold">
              {{$item->options->eventPlace ?? ''}}
            </div>
            <div class="hour">
              {{$item->options->eventHour ?? ''}}
            </div>
          </h3>
          <i class="icon fa fa-home {{$item->options->icon ?? ''}}"></i>
        </div>
        <div class="body">
          <hr>
          <h2>{{$item->title}}</h2>
          <ul>
            <li> {!! $item->description ? $item->description : $item->summary !!}</li>
          </ul>
          <hr>
        </div>
      </div>
    @endforeach
  </div>
</div>
