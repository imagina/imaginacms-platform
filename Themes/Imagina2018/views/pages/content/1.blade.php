<div class="home" data-icontenttype="page" data-icontentid="1">
{{--        slider section--}}
    <div class="container slider-main mb-5 p-0">
        <section class=" general-block11  p-0" data-blocksrc="general.block11">
            {!!Slider::render('home','slider.main.slider')!!}
        </section>
    </div>

{{--    product new--}}
    @include('icommerce.widgets.product-new')
{{--    categories by images--}}
    <div class="container">
        <div class="row"></div>
        @include('icommerce.widgets.categories-img')
    </div>

{{--    best seller--}}
{{--    @include('icommerce.widgets.destacados')--}}
    @include('icommerce.widgets.bestsellers')

    

</div>














