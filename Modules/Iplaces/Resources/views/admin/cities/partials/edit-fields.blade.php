<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('iplaces::cities.form.title')) !!}
        <?php $old = $city->hasTranslation($lang) ? $city->translate($lang)->title : '' ?>
        {!! Form::text("{$lang}[title]", old("{$lang}.title", $old), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iplaces::cities.form.title')]) !!}
        {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
    </div>
    <?php $old = $city->hasTranslation($lang) ? $city->translate($lang)->description : '' ?>
    <div class='form-group{{ $errors->has("$lang.description") ? ' has-error' : '' }}'>
        @editor('description', trans('iplaces::cities.form.description'), old("$lang.description", $old), $lang)
    </div>
</div>
