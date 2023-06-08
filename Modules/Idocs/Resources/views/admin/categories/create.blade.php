@extends('layouts.master')

@section('content-header')
  <h1>
    {{ trans('idocs::categories.title.create category') }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard.index') }}"><i
          class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('admin.idocs.category.index') }}">{{ trans('idocs::categories.title.categories') }}</a></li>
    <li class="active">{{ trans('idocs::categories.title.create category') }}</li>
  </ol>
@stop

@section('content')
  {!! Form::open(['route' => ['admin.idocs.category.store'], 'method' => 'post']) !!}
  <div class="row">
    <div class="col-xs-12 col-md-9">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
              </button>
            </div>
            <div class="nav-tabs-custom">
              @include('partials.form-tab-headers')
              <div class="tab-content">
                  <?php $i = 0; ?>
                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                      <?php $i++; ?>
                  <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                    @include('idocs::admin.categories.partials.create-fields', ['lang' => $locale])
                  </div>
                @endforeach
              </div>
            </div> {{-- end nav-tabs-custom --}}
          </div>
        </div>
        @if (config('asgard.idocs.config.fields.category.partials.normal.create')&&config('asgard.idocs.config.fields.category.partials.normal.create') !== [])
          <div class="col-xs-12 ">
            <div class="box box-primary">
              <div class="box-header">
              </div>
              <div class="box-body ">
                @foreach (config('asgard.idocs.config.fields.category.partials.normal.create') as $partial)
                  @include($partial)
                @endforeach

              </div>
            </div>
          </div>
        @endif
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header">
            </div>
            <div class="box-body ">
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.idocs.category.index')}}"><i
                    class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-md-3">
      <div class="row">
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
                </button>
              </div>
              <div class="form-group">
                <label>{{trans('idocs::categories.form.parent category')}}</label>
              </div>
            </div>
            <div class="box-body">
              <select class="form-control" name="parent_id" id="parent_id">
                <option value="0">-</option>
                @foreach ($categories as $category)
                  <option
                    value="{{$category->id}}" {{ old('parent_id', 0) == $category->id ? 'selected' : '' }}> {{$category->title}}
                  </option>
                @endforeach
              </select><br>
            </div>
          </div>
        </div>
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
                </button>
              </div>
              <div class="form-group">
                <label>{{trans('idocs::categories.form.image')}}</label>
              </div>
            </div>
            <div class="box-body">
              <div class="tab-content">
                @mediaSingle('mainimage')
              </div>
            </div>
          </div>
        </div>
        @if(config('asgard.idocs.config.fields.category.secondaryImage'))
          <div class="col-xs-12 ">
            <div class="box box-primary">
              <div class="box-header">
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                      class="fa fa-minus"></i>
                  </button>
                </div>
                <div class="form-group">
                  <label>{{trans('idocs::categories.form.secondary image')}}</label>
                </div>
              </div>
              <div class="box-body">
                <div class="tab-content">
                  @mediaSingle('secondaryimage')
                </div>
              </div>
            </div>
          </div>
        @endif
        @if ((config('asgard.idocs.config.fields.documents.identification')&&config('asgard.idocs.config.fields.documents.identification') !== [])|| (config('asgard.idocs.config.fields.documents.users')&&config('asgard.idocs.config.fields.documents.users') !== []))
          <div class="col-xs-12 ">
            <div class="box box-primary">
              <div class="box-header">
                <label>{{trans('idocs::categories.form.private')}}</label>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                      class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body ">
                <div class='form-group{{ $errors->has("private") ? ' has-error' : '' }}'>
                  <label class="checkbox" for="private">
                    <input type="checkbox" id="private" name="privete"
                           value="1" {{ old('private',1) == 1? 'checked' : '' }}>
                    {{trans('idocs::categories.form.private')}}
                  </label>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@stop

@section('footer')
  <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
  <dl class="dl-horizontal">
    <dt><code>b</code></dt>
    <dd>{{ trans('core::core.back to index') }}</dd>
  </dl>
@stop

@push('js-stack')
  <script type="text/javascript">
      $(document).ready(function () {
          $(document).keypressAction({
              actions: [
                  {key: 'b', route: "<?= route('admin.idocs.category.index') ?>"}
              ]
          });
      });
  </script>
  <script>
      $(document).ready(function () {
          $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
              checkboxClass: 'icheckbox_flat-blue',
              radioClass: 'iradio_flat-blue'
          });
      });
  </script>
@endpush
