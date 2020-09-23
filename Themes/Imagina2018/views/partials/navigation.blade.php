<nav class="navbar navbar-expand-lg navbar-light ml-0 p-0">
    
    <div class="collapse navbar-collapse row" id="pinturasNavbar">
        {{--				Categories menu--}}
        <div class="col-12 col-lg-auto">
            @include('partials.categories')
        </div>
        <div class="col-lg-auto border-left">
            @menu('main')
        </div>
        {{--				social network--}}
        <div class="col-12 col-lg-auto ml-auto border-left">
            @include('partials.social')
        </div>

    </div>
</nav>