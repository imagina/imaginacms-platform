@extends('layouts.master')
@section('title')
    {{trans('isearch::common.title')}}-{{$searchphrase}} | @parent
@stop
@section('content')

    <div class="page blog isearch">
        <div class="container">
            <div class="row">

                <div class="row">
                    <div class="col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="/">Inicio</a></li>
                            <li>{{trans('isearch::common.search')}} "{{$searchphrase}}"</li>
                        </ol>
                    </div>
                </div>

                <!-- Blog Entries Column -->
                <div class="col-xs-12 col-md-12 category-body-1">

                    <h1 class="page-header">{{trans('isearch::common.search')}} "{{$searchphrase}}"</h1>

                    @if (isset($result) && !empty($result))
                        @foreach($result as $k => $entities)

                            @php $cont = 0; @endphp
                            <h2 class="page-header">{{$entities['title']}}</h2>
                            @if(count($entities['items']) == 0)
                                <h5>
                                    {{trans('isearch::common.index.Not Found')}} </h5>
                            @endif
                            <div class="card-deck">
                                @foreach($entities['items'] as $result)
                                <!-- Blog Post and/or E-commerce Product -->
                                    <div class="card contend post post{{$result->id}}">
                                        <x-media::single-image :alt="$result->title ?? $result->name" :title="$result->title ?? $result->name" :url="$result->url" :isMedia="true"
                                               :mediaFiles="$result->mediaFiles()" imgClasses="card-img-top"/>
                                        <div class="card-body">
                                            <div class="card-title">
                                                <a href="{{$result->url}}"><h2>{{$result->title ?? $result->name}}</h2></a>
                                            </div>
                                            <p class="card-text">
                                                {!! $result->summary!!}
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a class="btn btn-primary post-link"
                                               href="{{$result->url}}">{{trans('isearch::common.index.Read More')}}<span
                                                        class="glyphicon glyphicon-chevron-right"></span></a>
                                        </div>
                                    </div>
                                    @php $cont++; @endphp
                                @endforeach
                            </div>
                            <div class="clearfix"></div>
                            <div class="pagination paginacion-blog row">
                                <div class="pull-right">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <div class="error-template">
                                    <h2 class="h1">
                                        Oops!</h2>
                                    <h2>
                                        {{trans('isearch::common.index.Not Found')}} </h2>
                                    <div class="error-details">
                                        {{trans('isearch::common.index.Not msg')}}
                                    </div>
                                    <div class="error-actions">
                                        <a href="{{url('/')}}" class="btn btn-primary btn-lg"><span
                                                    class="glyphicon glyphicon-home"></span>
                                            {{trans('isearch::common.index.Not btn')}} </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>
@stop

@section('scripts')
    @parent
    <link rel="stylesheet" href="{{url('modules/isearch/css/isearch.css')}}">
@endsection
