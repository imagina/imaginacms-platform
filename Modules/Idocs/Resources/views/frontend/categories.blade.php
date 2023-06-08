@extends('layouts.master')

@section('meta')
  @include('idocs::frontend.partials.category.metas')
@stop
@section('title')
  {{$category->title??''}} | @parent
@stop
@section('content')
  <div class="docs-category-{{$category->id}}">
    <div class="container">

      <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-12 col-md-8">

          <h1 class="my-4">{{$category->title}}
          </h1>
         {!! $category->description !!}

        @if (count($documents))
          @foreach($documents as $document)
            <!-- Blog Post -->
              <div class="card mb-4">
                {!!$document->present()->icon()!!}
                <div class="card-body">
                  <a href="{{$document->file->path}}"
                     class="btn btn-primary" target="_blank">{{$document->title}}</a>
                </div>
              </div>
          @endforeach
          <!-- Pagination -->
            <div class="pagination justify-content-center mb-4 pagination paginacion-blog row">
              <div class="pull-right">
                {{$documents->links('pagination::bootstrap-4')}}
              </div>
            </div>
          @else
            <div class="col-xs-12 con-sm-12">
              <div class="white-box">
                <h3>Ups... :(</h3>
                <h1>404 Post no encontrado</h1>
                <hr>
                <p style="text-align: center;">No hemos podido encontrar el Contenido que estás
                  buscando.</p>
              </div>
            </div>
              @endif


        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-12 col-md-4">

          <!-- Search Widget -->
          <div class="card my-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
              <form id="doc-search-input" class="form-inline" method="GET" onsubmit="return docSearchForm('identification')">
                <div class="input-group col-12 mb-3 mt-3">
                  <input type="text" class="form-control" placeholder="{{trans('idocs::documents.form.document')}} " name="search" id ="identification" maxlength="64" required>
                  <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit"><span class="fa fa-search"></span></button>
                    </span>
                </div><!-- /input-group -->
              </form>
            </div>
          </div>

          <!-- Categories Widget -->
          @if(count($category->children))
          <div class="card my-4">
            <h5 class="card-header">{{trans('idocs::category.list')}}</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">

                      @foreach($category->children as $subcategory)
                        <li>
                          <a href="{{$subcategory->url}}">{{$subcategory->title}}</a>
                        </li>
                      @endforeach

                  </ul>
                </div>
              </div>
            </div>
          </div>
        @endif
          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">Side Widget</h5>
            <div class="card-body">
              You can put anything you want inside of these side widgets. They are easy to use,
              and
              feature the new Bootstrap 4 card containers!
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
  </div>
@stop

@section('scripts')
      @parent
      <script type="text/javascript">
          function docSearchForm(idsearch){
              rut = "{{route('idocs.document.search')}}";
              rut2 = rut+'?q='+document.getElementById(idsearch).value;
              location.href = rut2;
              return false;
          }
      </script>
@stop