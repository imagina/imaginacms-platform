
    
    <div id="timelineLayout1" class="timeline">
  
      <ul>
          @foreach($items as $index => $item)
          <li>
            <div class="content">
              <div class="row">
                @if($index%2 == 0)
                <div class="col-8">
                    <h3>{{$item->title}}</h3>
                    {!! $item->description !!}
                  </div>
      
                  <div class="col-4">
                    <i class="img">
                        <x-media::single-image :isMedia="true" :mediaFiles="$item->mediaFiles()" />
                      </i>
                  </div>
                @else
                <div class="col-4">
                    <i class="img">
                        <x-media::single-image :isMedia="true" :mediaFiles="$item->mediaFiles()" />
                      </i>
                  </div>
      
                  <div class="col-8">
                   
                    <h3>{{$item->title}}</h3>
                    {!! $item->description !!}
                  </div>
                @endif
             
              </div>
            </div>
            <div class="time">
              <h4>2015</h4>
    
            </div>
    
          </li>
          @endforeach
          <div style="clear: both;"></div>
      </ul>
  
    </div>
  