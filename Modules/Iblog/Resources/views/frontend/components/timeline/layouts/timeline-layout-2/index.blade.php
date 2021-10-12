<div id="timelineLayout2" class="timeline">

    <div class="entry">
        @foreach($items as $index => $item)
      <div class="title">
        <h3>06 | 05 <br>
        Title <br> 9:00 Am </h3>
        <i class="{{$item->icom}}" style=" opacity: 0.5;"></i>
      </div>
      <div class="body">
        <hr>
        <p>{{$item->title}}</p>
        <ul>
          <li > {!! $item->description !!}</li>
         
        </ul>
        <hr>
      </div>
      @endforeach
    </div>
   
    
  
  </div>

