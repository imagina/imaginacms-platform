<?php
/*$categories = get_Iplaces_categories(['take' => 50, 'order' => 'asc']);
$nameCategory = '';
if (ist($category) && !empty($category)){
    $nameCategory = $category->title;
}*/
?>
<h4 class="text-primary font-weight-bold mb-2">Filtrar por:</h4>


<div id="listFilters" class="border border-gray-lighter ">
    @php $counter = 0; @endphp
    @foreach($categories->reverse() as $key => $categoryParent)
        @php $counter++; @endphp

        @if(count($categoryParent->children))
            <button class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
                       border-bottom border-gray-border border-left-0 border-right-0 rounded-0"
                    type="button" data-toggle="collapse" data-target="#filter-{{$counter}}" aria-expanded="false"
                    aria-controls="filter-{{$counter}}">
                <strong>{{$categoryParent->title}}</strong>
                <i class="fa fa-caret-down float-right mt-1" aria-hidden="true"></i>
            </button>

            @php
                $category = $categoryParent->children()->get();
            @endphp
            <ul class="filter-options collapse @if($counter == 1) show @endif" id="filter-{{$counter}}">
                @foreach($category as $item)
                    <?php
                    $colorClass = 'text-gray-text-color';
                    if (isset($categoriesPost) && !empty($categoriesPost)){
                        if (in_array($item->id,$categoriesPost)){
                            $colorClass = 'text-primary';
                        }
                    }
                    ?>
                    <li class="d-list-item font-weight-semi-bold">
                        <a id="{{$item->id}}" onclick="filter(this)" class="{{$colorClass}}">
                            {{$item->title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

    @endforeach


    <!-- Formulario -->
    {{-- <form id="formCategory"
          action="{{route(App::getLocale().'.iplaces.filter')}}"
          method="post">
        {{ csrf_field() }}
        <input id="categories" type="hidden" name="categories" value="">
    </form>--}}
</div>


@section('scripts')
    @parent

    <script>
        {{--  var categories = [];

        // SI hay array de categorias lo guarda en js
        @if(isset($categoriesPost) && !empty($categoriesPost))
            categories = {{json_encode($categoriesPost)}};
        @endif

        function filter(item){
            var id = parseInt($(item).attr('id'));
            var position = parseInt(categories.indexOf(id));
            if(position === -1){
                categories.push(id);
            }else{
                categories.splice(position, 1);
            }

            if(categories.length <= 0){
                location.href = '/lugares';
            }else {
                var data = JSON.stringify(categories);
                $('#categories').val(data);
                $('#formCategory').submit();
            }
        }--}}
    </script>
@stop










