@extends('layouts.master')

@section('title')
    {{ $page->title }} | @parent
@stop
@section('meta')
    <meta name="title" content="{{ $page->meta_title}}" />
    <meta name="description" content="{{ $page->meta_description }}" />
@stop

@section('content')

    @if(LaravelLocalization::getDefaultLocale()==LaravelLocalization::getCurrentLocale())
        @if(View::exists('pages.content.'.$page->id))
            @include('pages.content.'.$page->id)
        @endif
    @else

        @if(View::exists('pages.content.'.LaravelLocalization::getCurrentLocale().'.'.$page->id))
            @include('pages.content.'.LaravelLocalization::getCurrentLocale().'.'.$page->id)
        @endif
    @endif

@stop

@section ('scripts')


    @if(!empty($currentUser->id) && $currentUser->hasaccess('page.pages.edit'))
        <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>


        <script>

            $(window).on('load', function (e) {

                $("div[data-icontenttype='page'] div.icontenteditable").attr('contenteditable', 'true');

                CKEDITOR.dtd.$removeEmpty['i'] = false

                CKEDITOR.on( 'instanceCreated', function ( event ) {
                    var editor = event.editor,
                        element = editor.element;

                    editor.on( 'configLoaded', function () {

                        editor.config.extraAllowedContent = '*(col-md-*,row,fa,fa-*,btn,btn-*)';


                        // Remove redundant plugins to make the editor simpler.
                        editor.config.removePlugins = 'colorbutton,find,flash,font,' +
                            'forms,iframe,image,newpage,removeformat,' +
                            'smiley,specialchar,stylescombo,templates';

                        // Rearrange the toolbar layout.
                        editor.config.toolbarGroups = [
                            { name: 'editing', groups: [ 'basicstyles', 'links' ] },
                            { name: 'undo' },
                            { name: 'clipboard', groups: [ 'selection', 'clipboard' ] },
                            { name: 'styles', groups: [ 'styles' ] },
                            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},

                        ];
                    });

                });

                <?php
                if(\LaravelLocalization::getDefaultLocale()==\LaravelLocalization::getCurrentLocale()) {
                    $saveurl = "/inline/save";
                } else {
                    $saveurl = \LaravelLocalization::getCurrentLocale().'/inline/save';
                }
                ?>



                CKEDITOR.inlineAll();

                $('.inline-save').click(function() {

                    inlinedata = [];

                    for (var i in CKEDITOR.instances) {
                        (function(i){
                            inlinedata[inlinedata.length] = CKEDITOR.instances[i].getData();
                        })(i);
                    }

                    data = {
                        'inlinedata':inlinedata,
                        'type':'page',
                        'id': $("div[data-icontenttype='page']").data('icontentid')
                    };

                    $.post('{{url($saveurl)}}',data,function(data) {
                        if(data.success=='true') {
                            alert('Pagina Guardada');
                        }
                    })

                })


            })

        </script>


        <div class="edit-footer">
            <div class="container">
                <div class="text-right">
                    <a class="btn btn-primary inline-save" >Guardar</a>
                </div>
            </div>
        </div>

    @endif
@stop