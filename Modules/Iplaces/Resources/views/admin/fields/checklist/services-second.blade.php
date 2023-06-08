<div class="row checkbox">
    <div class="col-xs-12">
        <label for="provinces"><strong>{{trans('iplaces::places.form.services.secondary')}}</strong></label>
        <div class="content-serv" style="max-height:300px;overflow-y: auto;">
            @if(count($servicesSecond)>0)
                @php
                    if(isset($place->services) && count($place->services)>0){
                    $oldServ = array();
                        foreach ($place->services as $serv){
                                   array_push($oldServ,$serv->id);
                               }

                           }else{
                           $oldServ=old('services');
                           }
                @endphp

                <ul class="checkbox" style="list-style: none;padding-left: 5px;">

                    @foreach ($servicesSecond as $serviceSecond)
                      
                            <li style="padding-top: 5px">
                                <label>
                                    <input type="checkbox" class="flat-blue jsInherit" name="services[]"
                                           value="{{$serviceSecond->id}}"
                                           @isset($oldServ) @if(in_array($serviceSecond->id, $oldServ)) checked="checked" @endif @endisset> {{$serviceSecond->title}}
                                </label>
                              
                            </li>


                    @endforeach

                </ul>

            @endif

        </div>
    </div>

</div>