<div class="row checkbox">

    <div class="col-xs-12">
        <div class="content-user" style="max-height:490px;overflow-y: auto;">

            <label for="users"><strong>{{trans('idocs::documents.form.users')}}</strong></label>


            @if(count($users)>0)
                @php
                    if(isset($document->users) && count($document->users)>0){
                    $oldUsers = array();
                        foreach ($document->users as $user){
                                   array_push($oldUsers,$user->id);
                               }

                           }else{
                           $oldUsers=old('users');
                           }
                @endphp

                <ul class="checkbox" style="list-style: none;padding-left: 5px;">
                    @foreach ($users as $user)
                            <li  style="padding-top: 5px">
                                <label>
                                    <input type="checkbox" class="flat-blue jsInherit" name="users[]"
                                           value="{{$user->id}}"
                                           @isset($oldUsers) @if(in_array($user->id, $oldUsers)) checked="checked" @endif @endisset> {{$user->present()->fullName()}}
                                </label>
                            </li>
                    @endforeach

                </ul>

            @endif

        </div>
    </div>

</div>