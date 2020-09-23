<section class="iblock general-block13 pb-5" data-blocksrc="general.block13">
    <div id="categoriesimg">
        <categories></categories>
    </div>
</section>



@section('scripts-owl')
    @parent

    <script>
        const categoriesimg = new Vue({
            el: '#categoriesimg'
        });
    </script>
@stop
