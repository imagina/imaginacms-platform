<div class="item-layout item-list-layout-1">
    <div class="card card-category card-item border-0">
        <div class="row align-items-center">
            <div class="col-12 {{$orderClasses["title"] ?? 'order-0'}} item-title">
                @if(isset($item->url))
                    <a href="{{$item->url}}">
                        @endif
                        <h3 class="title">
                            {{$item->title ?? $item->name}}
                        </h3>
                        @if(isset($item->url))
                    </a>
                @endif
            </div>
            <div class="col-12 {{$orderClasses["status"] ?? 'order-1'}}">
                Estado: {!!  $item->status == '1' ? "<b class='text-success'>Activo</b>" : "<b class='text-danger'>Inactivo</b>"  !!}
            </div>
            <div class="col-12 {{$orderClasses["date"] ?? 'order-2'}} item-created-date">
                <div class="created-date">Desde {{ $item->start_date->format($formatCreatedDate) }} hasta el {{ $item->end_date->format($formatCreatedDate) }}</div>
            </div>
        </div>
    </div>
</div>
