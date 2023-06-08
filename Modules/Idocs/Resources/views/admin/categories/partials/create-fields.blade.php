<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('idocs::categories.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("{$lang}.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('idocs::categories.form.title')]) !!}
        {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.description") ? ' has-error' : '' }}'>
        @editor('description', trans('idocs::categories.form.description'), old("{$lang}.description"), $lang)
    </div>


    @if (config('asgard.idocs.config.fields.category.partials.translatable.create') && config('asgard.idocs.config.fields.category.partials.translatable.create') !== [])
        @foreach (config('asgard.idocs.config.fields.category.partials.translatable.create') as $partial)
            @include($partial)
        @endforeach
    @endif
</div>