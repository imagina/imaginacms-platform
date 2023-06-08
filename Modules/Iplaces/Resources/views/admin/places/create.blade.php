@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iplaces::places.title.create place') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.iplaces.place.index') }}">{{ trans('iplaces::places.title.places') }}</a></li>
        <li class="active">{{ trans('iplaces::places.title.create place') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
    {!! Form::open(['route' => ['admin.iplaces.place.store'], 'method' => 'post']) !!}

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
                                        @include('iplaces::admin.places.partials.create-fields', ['lang' => $locale])
                                    </div>
                                @endforeach
                            </div> {{-- end nav-tabs-custom --}}
                        </div>
                    </div>
                </div>

                @include('iplaces::admin.places.partials.extra-fields-create')
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.galleries')}}</label>
                            </div>
                        </div>
                        <div class="box-body ">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <label for="options[videos]"><strong>{{trans('iplaces::place.form.Gallery')}}</strong></label>
                                    <button disabled type="button" data-toggle="modal" data-target="#modalGallery" class="form-control btn btn-primary btn-flat">{{ trans('iplaces::place.form.View Gallery') }}</button>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label for="options[videos]"><strong>{{trans('iplaces::place.form.videos')}}</strong></label>
                                    <textarea id="options" class="form-control" name="options[videos]" rows="3">{{ old('options[videos]')}}</textarea>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                        </div>
                        <div class="box-body ">
                            <div class="box-footer">
                                <button type="submit"
                                        class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                                <a class="btn btn-danger pull-right btn-flat"
                                   href="{{ route('admin.iplaces.place.index')}}">
                                    <i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
                                <label>{{trans('iplaces::categories.title.categories')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="categories"><strong>{{trans('iplaces::places.form.principal')}}</strong></label>
                            <select class="form-control" name="category_id">
                                @if(count($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{ old('category_id',0) == $category->id ? 'selected' : '' }}> {{$category->title}}
                                        </option>
                                    @endforeach
                                @endif
                            </select><br>
                        </div>
                        <div class="box-body">
                            @include('iplaces::admin.fields.checklist.parent')
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
                                <label>{{trans('iplaces::zones.form.zones')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="zones"><strong>{{trans('iplaces::zones.form.principal')}}</strong></label>
                            <select class="form-control" name="zone_id" id="zone_id">
                                @foreach ($zones as $zone)
                                    <option value="{{$zone->id}}" {{ old('zone_id', 0) == $zone->id ? 'selected' : '' }}> {{$zone->title}}
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
                                <label>{{trans('iplaces::common.form.provinces')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="provinces"><strong>{{trans('iplaces::common.form.principal')}}</strong></label>
                            <select class="form-control" name="province_id" id="province_id" required>
                                <option value=""> Select </option>
                                @foreach ($provinces as $province)
                                    <option value="{{$province->id}}" {{ old('province_id', 0) == $province->id ? 'selected' : '' }}> {{$province->translate('en')->name}}
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
                                <label>{{trans('iplaces::common.form.cities')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="cities"><strong>{{trans('iplaces::zones.form.principal')}}</strong></label>
                            <select class="form-control" name="city_id" id="city_id" required>
                                    <option value=""> Select </option>
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
                                <label>{{trans('iplaces::common.form.sites')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="sites"><strong>{{trans('iplaces::cities.form.principal')}}</strong></label>
                            <select class="form-control" name="site_id" id="site_id" required>
                                @foreach ($sites as $site)
                                    <option value="{{$site->id}}" {{ old('site_id', 0) == $site->id ? 'selected' : '' }}> {{$site->title}}
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
                                <label>{{trans('iplaces::schedules.form.schedules')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="schedule"><strong>{{trans('iplaces::schedules.form.principal')}}</strong></label>
                            <select class="form-control" name="schedule_id" id="schedule_id">
                                @foreach ($schedules as $schedule)
                                    <option value="{{$schedule->id}}" {{ old('schedule_id', 0) == $schedule->id ? 'selected' : '' }}> {{$schedule->title}}
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
                                <label>{{trans('iplaces::services.form.services')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            @include('iplaces::admin.fields.checklist.services')

                        </div>
                        <div class="box-body">
                            @include('iplaces::admin.fields.checklist.services-second')

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
                                <label>{{trans('iplaces::spaces.form.spaces')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            @include('iplaces::admin.fields.checklist.spaces')

                        </div>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <label>{{trans('iplaces::status.title')}}</label>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body ">
                            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                                <label class="radio" for="{{trans('iplaces::status.inactive')}}">
                                    <input type="radio" id="status" name="status"
                                           value="0" {{ old('status',0) == 0? 'checked' : '' }}>
                                    {{trans('iplaces::status.inactive')}}
                                </label>
                                <label class="radio" for="{{trans('iplaces::status.active')}}">
                                    <input type="radio" id="status" name="status"
                                           value="1" {{ old('status', 0) == 1? 'checked' : '' }}>
                                    {{trans('iplaces::status.active')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <label>{{trans('iplaces::places.form.validate')}}</label>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body ">
                            <div class='form-group{{ $errors->has("validated") ? ' has-error' : '' }}'>
                                <label class="checkbox" for="{{trans('iplaces::places.form.validate')}}">
                                    <input type="checkbox" id="validated" name="validated"
                                           value="1" {{ old('status',1) == 1? 'checked' : '' }}>
                                    {{trans('iplaces::places.form.validate')}}
                                </label>

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
                                <label>Image</label>
                            </div>
                            <div class="box-body">
                                @include('iplaces::admin.fields.image')
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
                                <label>Address</label>
                            </div>
                            <div class="box-body">
                                @include('iplaces::admin.fields.maps',['field'=>['name'=>'address', 'label'=>trans('iplaces::places.form.address')]])
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
                            <label>User</label>
                        </div>
                        <div class="box-body">
                            <select name="user_id" id="user" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{$user->id }}" {{$user->id == $currentUser->id ? 'selected' : ''}}>{{$user->present()->fullname()}}
                                        - ({{$user->email}})
                                    </option>
                                @endforeach
                            </select><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @stack('left_fields')
    {!! Form::close() !!}

     {{--   @include('iperformers::admin.fields.gallery',['entry'=>$prefromer??'','field'=>['name'=>'gallery', 'label'=>trans('iperformers::performers.form.gallery'),'route_upload'=>route('iplace.api.performers.gallery.store'),'route_delete'=>route('iperformers.api.performers.gallery.delete'),'folder'=>'assets/iperformers/performers/gallery/','label_drag'=>trans('iperformers::performers.form.drag')]])--}}
    </div>

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
                    {key: 'b', route: "<?= route('admin.iplaces.place.index') ?>"}
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
            $('.btn-box-tool').click(function (e) {
                e.preventDefault();
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#province_id').change(function () {
               var province='{"province_id":'+$("#province_id").val()+'}';
                $.ajax({
                    type: "GET",
                    url: "{{URL::route('ilocation.api.get.cities')}}",
                    dataType:'json',
                    data:{'take':null,'filter':province,'token':$('meta[name="token"]').attr('value')},
                    beforeSend: function(){
                        $('#city_id').prop('disabled',true)

                    },
                    success: function(data){
                        $('#city_id').prop('disabled',false)
                        $('#city_id').html('');
                        $.each(data.data, function (i, item) {

                            $('#city_id').append("<option value="+item.id+">"+item.name+"</option>")
                        });
                        {{--   {
                                $('#tab_logic').append(tr);

                                $('#tab_logic tbody tr').find("td button.row-remove").on("click", function () {
                                    $(this).closest("tr").remove();
                                });
                                var value=$('#providerautocomple').val();
                                $('input[id=provider'+newid+']').val(value);
                                $("tr#trProvider"+newid+" td #id-provider").val($('#data-holder').val());
                                $.each(data, function( index, value ) {
                                    $('select[id=product'+newid+']').append($('<option>', {
                                        value: value["id"],
                                        text : value["name"]
                                    }));
                                });
                                newid+=1;


                        }--}}

                        $('#providerautocomple').val("");
                        $('#data-holder').val("");
                    }
                });

            })

        });
    </script>
    <style>

        .nav-tabs-custom > .nav-tabs > li.active {
            border-top-color: white !important;
            border-bottom-color: #3c8dbc !important;
        }

        .nav-tabs-custom > .nav-tabs > li.active > a, .nav-tabs-custom > .nav-tabs > li.active:hover > a {
            border-left: 1px solid #e6e6fd !important;
            border-right: 1px solid #e6e6fd !important;

        }
    </style>
@endpush

