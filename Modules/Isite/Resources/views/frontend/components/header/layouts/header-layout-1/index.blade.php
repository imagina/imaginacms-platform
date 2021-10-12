<header id="header" class="container-fluid">
    <div class="row">
        <div class="col-2">
            <x-isite::Menu
                @foreach($components['megaMenu'] as $item=>$value)
                    {{ $item }}="{{ $value }}"
                @endforeach
            />
        </div>
        <div class="col-2">
            @include('partials.widgets.logo')
        </div>
        <div class="col-3">

        </div>
        <div class="col-2">

        </div>
        <div class="col-2">

        </div>
        <div class="col-1">

        </div>
    </div>
</header>
