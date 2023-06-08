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
<style>
  #timelineLayout2 {
    width: 100%;
    padding: 100px 50px;
    position: relative;
    background-color: #F8F8F8;
    height: 800px;
    overflow-y: scroll;
  }
  #timelineLayout2:before {
    content: '';
    position: absolute;
    top: 0px;
    left: calc(33% + 15px);
    bottom: 0px;
    width: 4px;
    background: #26227E;
  }
  #timelineLayout2:after {
    content: "";
    display: table;
    clear: both;
  }
  #timelineLayout2 .entry {
    clear: both;
    text-align: left;
    position: relative;
  }
  #timelineLayout2 .entry .content-timeline .title {
    margin-bottom: 1em;
    float: left;
    width: 33%;
    padding-right: 30px;
    text-align: right;
    position: relative;
    height: 124px;
    color: var(--primary);
  }
  #timelineLayout2 .entry .content-timeline .title:before {
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    border: 8px solid #A52485;
    background-color: #A52485;
    border-radius: 100%;
    top: 40%;
    right: -8px;
    z-index: 99;
  }
  #timelineLayout2 .entry .content-timeline .title i {
    position: absolute;
    display: inline-block;
    width: 40px;
    height: 40px;
    padding: 9px 0;
    top: 30%;
    right: -20px;
    background: #fff;
    border: 2px solid #A52485;
    border-radius: 40px;
    text-align: center;
    font-size: 18px;
    color: #000;
    z-index: 99;
    Transition: all 500ms ease-out;
    opacity: 0;
    visibility: hidden;
    opacity: 1 !important;
    background-repeat: no-repeat !important;
    background-size: 75% !important;
    background-position: center !important;
  }
  #timelineLayout2 .entry .content-timeline .title h3 {
    margin-bottom: 0;
    font-size: 120%;
    opacity: 0;
    visibility: hidden;
    Transition: all 500ms ease-out;
  }
  #timelineLayout2 .entry .content-timeline .title p {
    Transition: all 500ms ease-out;
    margin: 0px;
    margin-top: 10px;
    font-size: 100%;
    opacity: 0;
    visibility: hidden;
  }
  #timelineLayout2 .entry .content-timeline:hover .title i, #timelineLayout2 .entry .content-timeline:hover .title h3, #timelineLayout2 .entry .content-timeline:hover .title p {
    opacity: 1;
    visibility: visible;
  }
  #timelineLayout2 .entry .content-timeline:hover .body hr {
    background: #A52485;
    height: 5px;
    opacity: 1;
    visibility: visible;
  }
  #timelineLayout2 .entry .content-timeline:hover .body h2, #timelineLayout2 .entry .content-timeline:hover .body li {
    color: var(--primary);
  }
  #timelineLayout2 .entry .content-timeline:hover .body ul {
    display: block;
    opacity: 1;
    visibility: visible;
  }
  #timelineLayout2 .entry .content-timeline .body {
    margin: 0 0 1em;
    float: right;
    width: 66%;
    padding-left: 30px;
  }
  #timelineLayout2 .entry .content-timeline .body hr {
    Transition: all 500ms ease-out;
    opacity: 0;
    visibility: hidden;
    background: #A52485;
    height: 5px;
  }
  #timelineLayout2 .entry .content-timeline .body h2 {
    font-size: 18px;
    top: -25px;
    margin-bottom: 0.5em;
    line-height: 1.4em;
    height: 50px;
  }
  #timelineLayout2 .entry .content-timeline .body h2:first-child {
    margin-top: 0;
    font-weight: 400;
  }
  #timelineLayout2 .entry .content-timeline .body ul {
    display: none;
    color: #000;
    padding-left: 0;
    list-style-type: none;
    opacity: 0;
    visibility: hidden;
    Transition: all 500ms ease-out;
  }
  #timelineLayout2 .entry .content-timeline .body ul li:before {
    margin-right: 0.5em;
  }
  @media (max-width: 576px) {
    #timelineLayout2 {
      padding: 50px 5px;
    }
    #timelineLayout2:before {
      left: calc(1% + 15px);
    }
    #timelineLayout2 .entry .content-timeline .title {
      height: 45px !important;
      width: 97% !important;
      padding-right: 0px !important;
      padding-left: 47px;
    }
    #timelineLayout2 .entry .content-timeline .title:before {
      left: 8px;
    }
    #timelineLayout2 .entry .content-timeline .title i {
      left: -1px;
      right: unset;
      opacity: 1;
      visibility: visible;
    }
    #timelineLayout2 .entry .content-timeline .title h3, #timelineLayout2 .entry .content-timeline .title p {
      opacity: 1;
      visibility: visible;
      text-align: left;
    }
    #timelineLayout2 .entry .content-timeline .body {
      width: 96% !important;
    }
    #timelineLayout2 .entry .content-timeline .body hr:first-child {
      opacity: 1;
      visibility: visible;
    }
    #timelineLayout2 .entry .content-timeline .body h2 {
      height: 49px;
    }
  }
  #timelineLayout2::-webkit-scrollbar {
    -webkit-appearance: none;
  }
  #timelineLayout2::-webkit-scrollbar:vertical {
    width: 13px;
  }
  #timelineLayout2::-webkit-scrollbar-button:increment, #timelineLayout2::-webkit-scrollbar-button {
    display: none;
  }
  #timelineLayout2::-webkit-scrollbar:horizontal {
    height: 10px;
  }
  #timelineLayout2::-webkit-scrollbar-thumb {
    background-color: #E1E1E1;
    border-radius: 20px;
    border: 2px solid #f1f2f3;
  }
  #timelineLayout2::-webkit-scrollbar-track {
    border-radius: 10px;
  }

</style>