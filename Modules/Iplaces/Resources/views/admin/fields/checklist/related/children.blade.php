@if(count($children)>0)

    <ul style="list-style: none;">

        @foreach ($children as $x => $child)



            <li  style="padding-top: 5px">
                <label>
                    <input type="checkbox" class="flat-blue jsInherit" name="related[]" value="{{$child->id}}"
                           @isset($oldCat) @if(in_array($child->id, $oldCat)) checked="checked" @endif @endisset> {{$child->title}}

                </label>
                @if(count($child->children)>0)
                    @php
                        $children=$child->children
                    @endphp
                    @include('iperformers::admin.fields.checklist.related.children',['children'=>$children])
                @endif
            </li>

        @endforeach

    </ul>

@endif