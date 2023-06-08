
    
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
              <h4>{{$item->options->valueIdFieldTimeLine ?? $item->created_at}}</h4>
    
            </div>
    
          </li>
          @endforeach
          <div style="clear: both;"></div>
      </ul>
  
    </div>
    <style>
        #timelineLayout1 {
            position: relative;
            margin: 50px auto;
            padding: 40px 0;
            width: 1000px;
        }
        #timelineLayout1:before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 100%;
            background-color: #c5c5c5;
        }
        #timelineLayout1 ul {
            margin: 0px;
            padding: 0px;
        }
        #timelineLayout1 ul li {
            list-style: none;
            position: relative;
            width: 50%;
            padding: 20px 40px;
            box-sizing: border-box;
        }
        #timelineLayout1 ul li:nth-child(odd) {
            float: left;
            text-align: right;
            clear: both;
            top: -12px;
        }
        #timelineLayout1 ul li:nth-child(odd):before {
            content: "";
            position: absolute;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #ffffff;
            border: 4px solid #014898;
            top: 45%;
            right: -10px;
            outline: 5px solid white;
        }
        #timelineLayout1 ul li:nth-child(odd) .time {
            position: absolute;
            display: inline-block;
            top: 42%;
            right: -105px;
            margin: 0;
            text-align: center;
            font-weight: bold;
            color: #ffff;
            background: #014898;
            border-radius: 8px;
            padding: 8px 16px;
        }
        #timelineLayout1 ul li:nth-child(odd) .time:before {
            content: "";
            position: absolute;
            top: 10px;
            left: -8px;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-right: 10px solid #014898;
        }
        #timelineLayout1 ul li:nth-child(even) {
            float: right;
            text-align: left;
            clear: both;
        }
        #timelineLayout1 ul li:nth-child(even):before {
            content: "";
            position: absolute;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #ffffff;
            border: 4px solid #014898;
            top: 45%;
            left: -10px;
            outline: 5px solid white;
        }
        #timelineLayout1 ul li:nth-child(even) .time {
            position: absolute;
            display: inline-block;
            top: 42%;
            left: -105px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #ffff;
            background: #014898;
            border-radius: 8px;
            padding: 8px 16px;
        }
        #timelineLayout1 ul li:nth-child(even) .time:before {
            content: "";
            position: absolute;
            top: 10px;
            right: -8px;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-left: 10px solid #014898;
        }
        #timelineLayout1 ul li h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            font-weight: normal;
            color: #000;
        }
        #timelineLayout1 ul li p {
            margin: 0 0 10px 0;
            font-weight: normal;
            color: #000;
            padding: 0px;
        }
        #timelineLayout1 ul li .time h4 {
            margin: 0px;
            padding: 0;
            font-size: 14px;
        }
        #timelineLayout1 .content {
            padding-bottom: 20px;
        }
        #timelineLayout1 .content img {
            margin: auto;
            display: block;
            width: 150px;
            position: relative;
        }
        @media (max-width: 1000px) {
            #timelineLayout1 {
                width: 100%;
                padding-bottom: 0;
            }
        }
        @media (max-width: 767px) {
            #timelineLayout1 {
                width: 100%;
            }
            #timelineLayout1:before {
                left: 20px;
            }
            #timelineLayout1 ul li:nth-child(odd), #timelineLayout1 ul li:nth-child(even) {
                width: 100%;
                text-align: left;
                padding-left: 50px;
                padding-bottom: 50px;
            }
            #timelineLayout1 ul li:nth-child(odd):before, #timelineLayout1 ul li:nth-child(even):before {
                top: -18px !important;
                left: 10px !important;
            }
            #timelineLayout1 ul li:nth-child(odd) .time, #timelineLayout1 ul li:nth-child(even) .time {
                top: -25px !important;
                left: 50px !important;
                right: inherit !important;
            }
            #timelineLayout1 ul li:nth-child(odd) .time:before, #timelineLayout1 ul li:nth-child(even) .time:before {
                left: -10px !important;
            }
            #timelineLayout1 ul li:nth-child(even) .time:before {
                border-left: 0px solid #014898;
                border-right: 10px solid #014898;
                right: auto;
            }
        }

    </style>