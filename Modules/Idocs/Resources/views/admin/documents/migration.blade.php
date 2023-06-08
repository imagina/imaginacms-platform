@extends('layouts.master')

@section('content-header')
  <h1>
    {{ trans('idocs::documents.title.create document') }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard.index') }}"><i
          class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('admin.idocs.document.index') }}">{{ trans('idocs::documents.title.documents') }}</a></li>
    <li class="active">{{ trans('idocs::documents.title.import documents') }}</li>
  </ol>
@stop

@section('content')
  {!! Form::open(['route' => ['admin.idocs.document.import'], 'method' => 'post']) !!}
  <div class="row">
    <div class="col-xs-12">
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
                <label>{{trans('idocs::documents.form.import document')}}</label>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="form-group col-xs-12 col-sm-4 col-sm-offset-4">
                  <label for="exampleFormControlSelect1">{{trans('idocs::documents.form.language')}}</label>
                  <select class="form-control" name="Locale" id="Locale" >
                    @foreach($locale as $localeCode => $properties)
                      <option value="{{$localeCode}}">{{ $properties['native'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="form-group form-group col-xs-12 col-sm-4 col-sm-offset-4">
                  <label for="InputFile">{{trans('idocs::documents.form.Select File')}}</label>
                  <input type="file"
                         id="InputFile"
                         name="file"
                         accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                         style="margin: auto">
                  <p class="help-block">{{trans('idocs::documents.messages.Select File compatible files CSV, XLSX')}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header">
            </div>
            <div class="box-body ">
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('idocs::documents.button.import') }}</button>
                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.idocs.document.index')}}"><i
                    class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
