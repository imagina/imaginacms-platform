@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iplaces::cities.title.edit city') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.iplaces.city.index') }}">{{ trans('iplaces::cities.title.cities') }}</a></li>
        <li class="active">{{ trans('iplaces::cities.title.edit city') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.iplaces.city.update', $city->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('iplaces::admin.cities.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.iplaces.city.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
         <div class="col-md-3 col-xs-12">
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
                                 <label>{{trans('iplaces::common.form.provinces')}}</label>
                             </div>
                         </div>
                         <div class="box-body">
                             <label for="provinces"><strong>{{trans('iplaces::common.form.principal')}}</strong></label>
                             <select class="form-control" name="province_id" id="province_id" required>
                                 @foreach ($provinces as $province)
                                     <option value="{{$province->id}}" {{ old('province_id', $city->province_id) == $province->id ? 'selected' : '' }}> {{$province->translate('en')->name}}
                                     </option>
                                 @endforeach
                             </select><br>
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
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.iplaces.city.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
