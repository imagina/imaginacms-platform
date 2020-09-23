

<div class="card card-items mb-3 category">
    <div class="card-header">
        <a class="d-flex  align-items-center justify-content-between w-100"  data-toggle="collapse" href="#collapse-category2" role="button" aria-expanded="true"  aria-controls="collapse-category">
            Categorías<i class="fa fa-angle-down"></i>
        </a>
    </div>

    <div class="card-body p-0" id="collapse-category" class="sub-categoria collapse show" aria-labelledby="collapse-category" >

        <div class="card-menu" id="content_category" >
            <category parent="0" path="{{Request::url()}}" isParent='true'></category>
        </div>

    </div>
</div>




<div class="card card-items mb-3 category">
    <div class="card-header">
        <a class="d-flex  align-items-center justify-content-between w-100"  data-toggle="collapse" href="#collapse-category2" role="button" aria-expanded="true"  aria-controls="collapse-category2">
            Presentación<i class="fa fa-angle-down"></i>
        </a>
    </div>

    <div class="card-body p-0" id="collapse-category2" class="sub-categoria collapse show" aria-labelledby="collapse-category2" >

        <div class="card-menu" id="content_category" >
            <category parent="16" path="{{Request::url()}}" isParent='true'></category>
        </div>

    </div>
</div>
