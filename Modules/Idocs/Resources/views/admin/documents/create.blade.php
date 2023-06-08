@extends('layouts.master')

@section('content-header')
  <h1>
    {{ trans('idocs::documents.title.create document') }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard.index') }}"><i
          class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('admin.idocs.document.index') }}">{{ trans('idocs::documents.title.documents') }}</a></li>
    <li class="active">{{ trans('idocs::documents.title.create document') }}</li>
  </ol>
@stop

@section('content')
  {!! Form::open(['route' => ['admin.idocs.document.store'], 'method' => 'post']) !!}
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
                    @include('idocs::admin.documents.partials.create-fields', ['lang' => $locale])
                  </div>
                @endforeach
              </div>
            </div> {{-- end nav-tabs-custom --}}
          </div>
        </div>
        @if (config('asgard.idocs.config.fields.post.partials.normal.create')&&config('asgard.idocs.config.fields.post.partials.normal.create') !== [])
          <div class="col-xs-12 ">
            <div class="box box-primary">
              <div class="box-header">
              </div>
              <div class="box-body ">
                @foreach (config('asgard.idocs.config.fields.post.partials.normal.create') as $partial)
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
                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.idocs.document.index')}}"><i
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
                <label>{{trans('idocs::documents.form.principal category')}}</label>
              </div>
            </div>
            <div class="box-body">
              <select class="form-control" name="category_id" id="category_id">
                @foreach ($categories as $category)
                  <option
                    value="{{$category->id}}" {{ old('category_id', 0) == $category->id ? 'selected' : '' }}> {{$category->title}}
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
                <label>{{trans('idocs::documents.form.categories')}}</label>
              </div>
            </div>
            <div class="box-body">
              @include('idocs::admin.fields.checklist.categories.parent')
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
                <label>{{trans('idocs::documents.form.created at')}}</label>
              </div>
            </div>
            <div class="box-body">
              <div class="tab-content">
                <div class="form-group">
                  <div class='input-group date' id='created'>
                    <input type='text' name="created_at" id="created_at" class="form-control"
                           value="{{date('Y-m-d H:i:s')}}"/>
                    <span class="input-group-addon"><span
                        class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
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
                <label>{{trans('idocs::documents.form.file')}}</label>
              </div>
            </div>
            <div class="box-body">
              <div class="tab-content">
                @mediaSingle('file')
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <label>{{trans('idocs::documents.form.status_text')}}</label>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"
                        data-widget="collapse"><i
                    class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body ">
              <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                <label class="radio" for="inactive">
                  <input type="radio" id="status" name="status"
                         value="0" {{old('status',0) == 0 ? 'checked' : '' }}>
                  {{trans('idocs::documents.status.inactive')}}
                </label>
                <label class="radio" for="active">
                  <input type="radio" id="status" name="status"
                         value="1" {{old('status',0) == 1 ? 'checked' : '' }}>
                  {{trans('idocs::documents.status.active')}}
                </label>

              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"
                        data-widget="collapse"><i
                    class="fa fa-minus"></i>
                </button>
              </div>
              <label>{{trans('idocs::documents.form.user')}}</label>
            </div>
            <div class="box-body">
              <select name="user_id" id="user" class="form-control">
                @foreach ($users as $user)
                  <option
                    value="{{$user->id }}" {{$user->id == old('user_id') ? 'selected' : ''}}>{{$user->present()->fullname()}}
                    - ({{$user->email}})
                  </option>
                @endforeach
              </select><br>
            </div>
          </div>
        </div>
        @if (config('asgard.idocs.config.fields.documents.identification')&&config('asgard.idocs.config.fields.documents.identification') !== [])
          <div class="col-xs-12 ">
            <div class="box box-primary">
              <div class="box-header">
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                      class="fa fa-minus"></i>
                  </button>
                </div>
                <div class="form-group">
                  <label>{{trans('idocs::documents.form.users assigned')}}</label>
                </div>
              </div>
              <div class="box-body ">
                <div class='form-group{{ $errors->has("user_identification") ? ' has-error' : '' }}'>
                  {!! Form::label("user_identification", trans('idocs::documents.form.user identification')) !!}
                  {!! Form::text("user_identification", old("user_identification"), ['class' => 'form-control','placeholder' => trans('idocs::documents.form.user identification')]) !!}
                  {!! $errors->first("user_identification", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("email") ? ' has-error' : '' }}'>
                  {!! Form::label("email", trans('idocs::documents.form.email')) !!}
                  {!! Form::text("email", old("user_identification"), ['class' => 'form-control',  'placeholder' => trans('idocs::documents.form.email')]) !!}
                  {!! $errors->first("email", '<span class="help-block">:message</span>') !!}
                </div>
              </div>
            </div>
          </div>
        @endif
        @if (config('asgard.idocs.config.fields.documents.users')&&config('asgard.idocs.config.fields.documents.users') !== [])
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
                </button>
              </div>
              <div class="form-group">
                <label>{{trans('idocs::documents.form.users assigned')}}</label>
              </div>
            </div>
            <div class="box-body">
              @include('idocs::admin.fields.checklist.users.parent')
            </div>
          </div>
        </div>
        @endif
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
                </button>
              </div>
              <div class="form-group">
                <label>{{trans('idocs::documents.form.icon image')}}</label>
              </div>
            </div>
            <div class="box-body">
              <div class="tab-content">
                @mediaSingle('iconimage')
              </div>
            </div>
          </div>
        </div>
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
                  {key: 'b', route: "<?= route('admin.idocs.document.index') ?>"}
              ]
          });
      });
  </script>
  <script>
      $(document).ready(function () {
          $('input[type="checkbox"], input[type="radio"]').iCheck({
              checkboxClass: 'icheckbox_flat-blue',
              radioClass: 'iradio_flat-blue'
          });
      });
  </script>
@endpush
