@extends('layouts.master')

@section('meta')
  @include('idocs::frontend.partials.category.metas')
@stop
@section('title')
  {{trans('idocs::common.title.idocs')}} | @parent
@stop
@section('content')
  <div class="docs-category-all">
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-12">

          <h1 class="my-4">{{trans('idocs::common.title.idocs')}} - {{$searchphrase['identification']??''}} - {{$searchphrase['key']??''}}
          </h1>


          <div class="row">
            <div class="col-12">
              <div class="card my-4">
                <h5 class="card-header">Search</h5>
              <form id="doc-search-input" class="form-inline" method="GET" action="{{route('idocs.document.search')}}">
                <div class="input-group col-6 mb-3 mt-3">
                  <input type="text" class="form-control" placeholder="{{trans('idocs::documents.form.document')}} " name="q[identification]" id ="identification" maxlength="64" required>
                </div>
                <div class="input-group col-6 mb-3 mt-3">
                  <input type="text" class="form-control" placeholder="{{trans('idocs::documents.form.key')}} " name="q[key]" id ="key" maxlength="64" required>
                </div>
                <div class="input-group col-12 mb-3 mt-3">
                <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit"><span class="fa fa-search"></span></button>
                    </span>
                </div>
                <!-- /input-group -->
              </form>
              </div>
            </div>
          </div>

        @if (count($documents))
          @foreach($documents as $document)
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
          @elseif(isset($searchphrase['identification']))
            <h2 class="my-4">{{trans('idocs::documents.messages.not found')}}
            </h2>
          @endif

        </div>


      </div>
      <!-- /.row -->

    </div>
@stop

@section('scripts')
  @parent
@stop