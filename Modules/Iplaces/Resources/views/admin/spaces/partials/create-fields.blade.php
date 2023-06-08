<div class="box-body">
        <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[title]", trans('iplaces::services.form.title')) !!}
            {!! Form::text("{$lang}[title]", old("{$lang}.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iplaces::services.form.title')]) !!}
            {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
        </div>
        <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[slug]", trans('iplaces::services.form.slug')) !!}
            {!! Form::text("{$lang}[slug]", old("{$lang}.slug"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('iplaces::services.form.slug')]) !!}
            {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
        </div>
        <div class='form-group{{ $errors->has("$lang.description") ? ' has-error' : '' }}'>
        @editor('description', trans('iplaces::services.form.description'), old("{$lang}.description"), $lang)
        </div>
        <div class="col-xs-12" style="padding-top: 35px;">
            <div class="panel box box-primary">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a href="#aditional{{$lang}}" class="btn btn-box-tool" data-target="#aditional{{$lang}}"
                           data-toggle="collapse"><i class="fa fa-minus"></i>
                        </a>
                    </div>
                    <label>{{ trans('iplaces::common.form.metadata')}}</label>
                </div>
                <div class="panel-collapse collapse" id="aditional{{$lang}}">
                    <div class="box-body">
                        <div class='form-group{{ $errors->has("{$lang}.metatitle") ? ' has-error' : '' }}'>
                            {!! Form::label("{$lang}[metatitle]", trans('iplaces::common.form.metatitle')) !!}
                            {!! Form::text("{$lang}[metatitle]", old("{$lang}.metatitle"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iplaces::common.form.metatitle')]) !!}
                            {!! $errors->first("{$lang}.metatitle", '<span class="help-block">:message</span>') !!}
                        </div>
    
                        <div class='form-group{{ $errors->has("{$lang}.metakeywords") ? ' has-error' : '' }}'>
                            {!! Form::label("{$lang}[metakeywords]", trans('iplaces::common.form.metakeywords')) !!}
                            {!! Form::text("{$lang}[metakeywords]", old("{$lang}.metakeywords"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iplaces::common.form.metakeywords')]) !!}
                            {!! $errors->first("{$lang}.metakeywords", '<span class="help-block">:message</span>') !!}
                        </div>
    
                        @editor('metadescription', trans('iplaces::common.form.metadescription'),
                        old("{$lang}.metadescription"), $lang)
                    </div>
                </div>
            </div>
        </div>
    
        <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
        <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
        @include($partial)
        <?php endforeach; ?>
        <?php endif; ?>
    
</div> 