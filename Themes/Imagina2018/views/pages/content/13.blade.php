<div class="page" data-icontenttype="page" data-icontentid="12">
    
    @component('partials.widgets.breadcrumb')
    
        @if(! empty($page->image->path))
            @slot('img', $page->image->path)
        @endif
        @slot('titulo', $page->title)

         <li class="breadcrumb-item active">{{$page->title}} </li>
    @endcomponent
		 
    <section class="iblock general-block121 container-fluid mt-5 pb-5" data-blocksrc="general.block121">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-12 icontenteditable ">
                    <h3>Lorem ipsum dolor sit amet.</h3>
                <p>   Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae quaerat eaque nulla sit voluptatum, veritatis velit in laboriosam! Fugiat veritatis, praesentium pariatur! Reiciendis vitae, optio magni deleniti. Libero illo saepe veritatis autem dolorum. Natus quibusdam mollitia, vero cum aperiam laboriosam, atque placeat. Perspiciatis aperiam saepe velit quod quam. Omnis dicta voluptas maiores veritatis iure nam error odio tempore sint tenetur. Repellendus distinctio, assumenda nulla a beatae autem, maiores expedita quisquam natus dolore temporibus porro veritatis voluptas necessitatibus voluptatem tenetur, aut reiciendis vitae. Ut consequuntur voluptate sed dolores consectetur, culpa autem officiis velit, quaerat, necessitatibus molestiae tempora totam dolor veniam, nesciunt.</p>
                
        </div>
    </section>
    <section class="iblock general-block121 container-fluid mt-5 pb-5" data-blocksrc="general.block121">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12" id="whishlist">
                    @include('icommerce.widgets.owlwishlist')
                </div>
              
        </div>
    </section>




</div>




@section('scripts')
@parent
<script>
    new Vue({ el: '#whishlist' });
</script>
@endsection










