<header>
  
  <div class="header" style="background: {{Setting::get('site::color-primary')}};">
    <!-- header contend -->
    <div class="stripe" style="background: {{Setting::get('site::color-secondary')}};
      padding: 10px 20px;">
      <div class="text-right text-capitalize" style="text-align: right !important; text-transform: capitalize;">
        {{strftime("%B %d, %G")}}
      </div>
    </div>
    
    <div>
      <h1 class="title" style="text-align: center;
        width: 80%;
        font-size: 40px;
        margin: 74px auto;">
        {{trans('notification::messages.new-notification')}}
      </h1>
    </div>
    
    <div class="header-contend text-center py-3" style="padding: 1rem 0 !important; ">
      <div style=" border-radius: 50%;
        max-width: 150px;
        height: 150px;
        background: #fff;
        margin: auto;
        padding: 10px;
        overflow: hidden;
        border: {{Setting::get('site::color-primary')}} solid;
        z-index: 10000;">
        <img src="{{Setting::get('isite::logo1')}}" alt="" style="max-width: 120px; margin-top: 20px;">
      </div>
    </div>
  
  </div>
  
