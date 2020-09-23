<div class="page" data-icontenttype="page" data-icontentid="3">
    @component('partials.widgets.breadcrumb')
    
       	@if(! empty($page->image->path))
         @slot('img', $page->image->path)
        @endif
        @slot('titulo', $page->title)
        @slot('descripcion', $page->body)

         <li class="breadcrumb-item active">{{$page->title}} </li>
    @endcomponent

    <section class="contacto iblock general-block31 container-fluid mt-5 pb-5" data-blocksrc="general.block31">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="icontenteditable">
                        <h2>Contactanos</h2>
                        <h3>Fabricamos y comercializamos pinturas de la más alta calidad.</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sed modi quas error dolorem molestias fugit quis corporis aliquam cupiditate. Enim itaque eligendi voluptatibus consequuntur ullam dicta qui quae quod alias dolorum, nam recusandae, ut temporibus odio quo tempora. Omnis incidunt ducimus dolor cumque ipsum ab velit quos modi architecto et!</p>
                    </div>
                </div>
                <div class="col-lg-10 my-5">
                    {!! Forms::render('contacto','iforms::frontend.form.bt-horizontal.form') !!}
                </div>
            </div>
        </div>
    </section>

</div>















