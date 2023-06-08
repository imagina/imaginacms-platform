<div class="row checkbox">

    <div class="col-xs-12">
        <div class="content-cat" style="max-height:490px;overflow-y: auto;">

            <label for="categories"><strong>{{trans('iplaces::places.table.categories')}}</strong></label>


            @if(count($categories)>0)
                @php
                    if(isset($place->categories) && count($place->categories)>0){
                    $oldCat = array();
                        foreach ($place->categories as $cat){
                                   array_push($oldCat,$cat->id);
                               }

                           }else{
                           $oldCat=old('categories');
                           }
                @endphp

                <ul class="checkbox" style="list-style: none;padding-left: 5px;">

                    @foreach ($categories as $category)
                        @if($category->parent_id==0)
                            <li  style="padding-top: 5px">
                                <label>
                                    <input type="checkbox" class="flat-blue jsInherit" name="categories[]"

                                           value="{{$category->id}}"
                                           @isset($oldCat) @if(in_array($category->id, $oldCat)) checked="checked" @endif @endisset> {{$category->title}}
                                </label>
                                @if(count($category->children)>0)
                                    @php
                                        $children=$category->children
                                    @endphp
                                    @include('iplaces::admin.fields.checklist.children',['children'=>$children])
                                @endif
                            </li>

                        @endif

                    @endforeach

                </ul>

            @endif

        </div>
    </div>

</div>