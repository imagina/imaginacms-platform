@section('scripts-owl')
    @php
        $currency=localesymbol(isset($code ) ? $code : 'USD');
    @endphp
    <script>

        var icommerce = {
            locales: {!! json_encode(LaravelLocalization::getSupportedLocales()) !!},
            currentLocale: '{{locale()}}',
            currencySymbolLeft:"{{isset($curreny) ? $currency->symbol_left : '$'}}",
            currencySymbolRight:"{{isset($curreny) ? $currency->symbol_right : ''}}",
            curremcyCode:"{{isset($curreny) ?  $currency->code : ''}}",
            curremcyValue:"{{isset($curreny) ? $currency->value : ''}}",
            url:"{{url('/')}}"
        };

        window.Laravel = {!! json_encode([
                
            'user' => Auth::user(),
            'router'    =>[
                    'products_index'   => route('api.icommerce.products.index'),
                
                ],
                
            'trans' => [
                'search'    =>[
                    'see_all'   =>  trans('icommerce::common.search.see_all'),
                    'no_results'=>  trans('icommerce::common.search.no_results'),
                ],
                'must_login' => trans('icommerce::wishlists.alerts.must_login'),
                'cart'       => [
                    'add_cart'   =>  trans('icommerce::products.alerts.add_cart'),
                    'no_add_cart'   =>  trans('icommerce::products.alerts.no_add_cart'),
                ],
                'wishlist'  => [
                    'add'                   =>  trans('icommerce::wishlists.alerts.add'),
                    'product_in_wishlist'   =>  trans('icommerce::wishlists.alerts.product_in_wishlist'),
                    'item'                  =>  trans('icommerce::cart.table.item'),
                    'no_item'               =>  trans('icommerce::wishlists.messages.no_item'),
                    'unit_price'            =>  trans('icommerce::cart.table.unit_price'),
                    'picture'               =>  trans('icommerce::cart.table.picture'),
                    'delete'                =>  trans('icommerce::wishlists.alerts.delete'),
                ],
                'wishlists'  => [
                    'add'                   =>  trans('icommerce::wishlists.alerts.add'),
                    'product_in_wishlist'   =>  trans('icommerce::wishlists.alerts.product_in_wishlist'),
                    'item'                  =>  trans('icommerce::cart.table.item'),
                    'no_item'               =>  trans('icommerce::wishlists.messages.no_item'),
                    'unit_price'            =>  trans('icommerce::cart.table.unit_price'),
                    'picture'               =>  trans('icommerce::cart.table.picture'),
                    'delete'                =>  trans('icommerce::wishlists.alerts.delete'),
                ]
            ]
        ]) !!}
    </script>
    @parent

@stop
