<div class="col-10 text-center">

    <p>
        {{trans('icommerceauthorize::frontend.messages.welcome')}}
    </p>

    <div id="loading-icon" class="d-none">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
    </div>

    <form id="paymentForm">
        <input type="hidden" name="dataValue" id="dataValue"/>
        <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
        <button id="btnFormAutho" type="button"
            class="AcceptUI btn btn-success btn-lg text-white "
            data-billingAddressOptions='{"show":true, "required":false}' 
            data-apiLoginID="{{$apiLogin}}"
            data-clientKey="{{$clientKey}}"
            data-acceptUIFormBtnTxt="Submit" 
            data-acceptUIFormHeaderTxt="{{trans('icommerceauthorize::frontend.title.modal')}}" 
            data-responseHandler="responseHandler">{{trans('icommerceauthorize::frontend.button.pay')}}
        </button>
    </form>

</div>

@section('scripts')
    @parent
    <script type="text/javascript"
    src="{{$acceptJS}}"
    charset="utf-8">
    </script>

    <script type="text/javascript">
      
       
        function responseHandler(response) {
            if (response.messages.resultCode === "Error") {
                console.log("Authorize Response: Error");
                //alert("{{trans('icommerceauthorize::frontend.validation.finding')}}");

                var i = 0;
                while (i < response.messages.message.length) {
                    /*
                    console.log(
                        response.messages.message[i].code + ": " +
                        response.messages.message[i].text
                    );
                    */
                    alert(response.messages.message[i].text);
                    i = i + 1;
                }
            } else {
                console.log("Authorize Response: Good");
                
                var btnformAutho = document.getElementById("btnFormAutho").classList;
                btnformAutho.add("d-none");

                var btnLoading = document.getElementById("loading-icon").classList;
                btnLoading.remove("d-none");
                btnLoading.add("d-block");

                paymentFormUpdate(response.opaqueData);
            }
        }
        
        
        function paymentFormUpdate(opaqueData) {
           
            var url = "{{url('/icommerceauthorize/pay')}}";
            window.location.href = url+"/"+{{$order->id}}+"/"+{{$transaction->id}}+"/"+opaqueData.dataValue+"/"+opaqueData.dataDescriptor;

        }

    
    </script>
  

@stop
