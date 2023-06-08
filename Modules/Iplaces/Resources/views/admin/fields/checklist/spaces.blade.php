<div class="row checkbox">

    <div class="col-xs-12">
        <div class="content-serv" style="max-height:490px;overflow-y: auto;">
            @if(count($spaces)>0)
                @php
                    if(isset($place->spaces) && count($place->spaces)>0){
                        $oldSpace = array();
                        foreach ($place->spaces as $space){
                            array_push($oldSpace,$space->id);
                        }

                    }else{
                        $oldSpace = old('spaces');
                    }
                @endphp

                <ul class="checkbox" style="list-style: none;padding-left: 5px;">
                    @foreach ($spaces as $space)
                        <li style="padding-top: 5px">
                            <label>
                                <input type="checkbox" class="flat-blue jsInherit" name="spaces[]"
                                           value="{{$space->id}}"
                                           @isset($oldSpace) @if(in_array($space->id, $oldSpace)) checked="checked" @endif @endisset> {{$space->title}}
                            </label> 
                        </li>
                    @endforeach
                </ul>

            @endif
        </div>
    </div>

</div>