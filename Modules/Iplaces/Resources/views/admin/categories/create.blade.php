@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iplaces::categories.title.create category') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li>
            <a href="{{ route('admin.iplaces.category.index') }}">{{ trans('iplaces::categories.title.categories') }}</a>
        </li>
        <li class="active">{{ trans('iplaces::categories.title.create category') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.iplaces.category.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div class="nav-tabs-custom">
                            @include('partials.form-tab-headers')
                            <div class="tab-content">
                                <?php $i = 0; ?>
                                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                    <?php $i++; ?>
                                    <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                        @include('iplaces::admin.categories.partials.create-fields', ['lang' => $locale])
                                    </div>
                                @endforeach
                            </div> {{-- end nav-tabs-custom --}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                        </div>
                        <div class="box-body ">
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.iplaces.category.index')}}">
                                    <i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                            </div>
                            {{-- <div class="form-group">
                                 <label for="exampleInputEmail1 ">Email address</label>
                                 <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                             </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>{{trans('iplaces::categories.title.categories')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <select class="form-control" name="parent_id">
                                <option value="0">
                                    -
                                </option>
                                @if(count($categories))
                                    @foreach ($categories as $cat)
                                        <option value="{{$cat->id}}"> {{$cat->title}}
                                        </option>
                                    @endforeach
                                @endif
                            </select><br>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <label>{{trans('iplaces::status.title')}}</label>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body ">
                            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                                <label class="radio" for="{{trans('iplaces::status.inactive')}}">
                                    <input type="radio" id="status" name="status" value="0" checked>
                                    {{trans('iplaces::status.inactive')}}
                                </label>
                                <label class="radio" for="{{trans('iplaces::status.active')}}">
                                    <input type="radio" id="status" name="status" value="1">
                                    {{trans('iplaces::status.active')}}
                                </label>
                            </div>
                            {{-- <div class="form-group">
                                 <label for="exampleInputEmail1 ">Email address</label>
                                 <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                             </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
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

            </div>
        </div>
        </div>




        @push('js-stack')
            <script type="text/javascript">
                $(document).ready(function () {

                    $('#image').each(function (index) {
                        // Find DOM elements under this form-group element
                        var $mainImage = $(this).find('#mainImage');
                        var $uploadImage = $(this).find("#mainimage");
                        var $hiddenImage = $(this).find("#hiddenImage");
                        //var $remove = $(this).find("#remove")
                        // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
                        var options = {
                            viewMode: 2,
                            checkOrientation: false,
                            autoCropArea: 1,
                            responsive: true,
                            preview: $(this).attr('data-preview'),
                            aspectRatio: $(this).attr('data-aspectRatio')
                        };


                        // Hide 'Remove' button if there is no image saved
                        if (!$mainImage.attr('src')) {
                            //$remove.hide();
                        }
                        // Initialise hidden form input in case we submit with no change
                        //$.val($mainImage.attr('src'));

                        // Only initialize cropper plugin if crop is set to true

                        $uploadImage.change(function () {
                            var fileReader = new FileReader(),
                                files = this.files,
                                file;

                            if (!files.length) {
                                return;
                            }
                            file = files[0];

                            if (/^image\/\w+$/.test(file.type)) {
                                fileReader.readAsDataURL(file);
                                fileReader.onload = function () {
                                    $uploadImage.val("");
                                    $mainImage.attr('src', this.result);
                                    $hiddenImage.val(this.result);
                                    $('#hiddenImage').val(this.result);

                                };
                            } else {
                                alert("Por favor seleccione una imagen.");
                            }
                        });

                    });
                });
            </script>


        @endpush

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
                    {key: 'b', route: "<?= route('admin.iplaces.category.index') ?>"}
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

            $('.btn-box-tool').click(function(e){
                e.preventDefault();
            });
        });
    </script>
    <style>

        .nav-tabs-custom > .nav-tabs > li.active {
            border-top-color:white !important;
            border-bottom-color: #3c8dbc !important;
        }

        .nav-tabs-custom > .nav-tabs > li.active > a, .nav-tabs-custom > .nav-tabs > li.active:hover > a {
            border-left: 1px solid #e6e6fd !important;
            border-right: 1px solid #e6e6fd !important;

        }


    </style>
@endpush
