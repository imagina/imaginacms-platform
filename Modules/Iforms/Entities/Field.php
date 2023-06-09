<?php

namespace Modules\Iforms\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Iforms\Presenters\FieldPresenter;
use Modules\Isite\Traits\RevisionableTrait;

class Field extends Model
{
    use Translatable, PresentableTrait, AuditTrait, RevisionableTrait;

    public $transformer = 'Modules\Iforms\Transformers\FieldTransformer';

    public $entity = 'Modules\Iforms\Entities\Field';

    public $repository = 'Modules\Iforms\Repositories\FieldRepository';

    protected $table = 'iforms__fields';

    public $translatedAttributes = [
        'label',
        'placeholder',
        'description',
    ];

    protected $fillable = [
        'type',
        'name',
        'required',
        'form_id',
        'selectable',
        'order',
        'prefix',
        'suffix',
        'width',
        'block_id',
        'options',
        'rules',
    ];

    protected $presenter = FieldPresenter::class;

    protected $casts = [
        'selectable' => 'array',
        'prefix' => 'array',
        'suffix' => 'array',
        'options' => 'array',
        'rules' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function getSelectableAttribute($value)
    {
        return json_decode($value);
    }

    public function setSelectableAttribute($value)
    {
        $this->attributes['selectable'] = json_encode($value);
    }

    public function getPrefixAttribute($value)
    {
        return json_decode($value);
    }

    public function getLabelAttribute($value)
    {
        return $value.($this->required ? config('asgard.iforms.config.requiredFieldLabel') : '');
    }

    public function setPrefixAttribute($value)
    {
        $this->attributes['prefix'] = json_encode($value);
    }

    public function getSuffixAttribute($value)
    {
        return json_decode($value);
    }

    public function setSuffixAttribute($value)
    {
        $this->attributes['suffix'] = json_encode($value);
    }

    public function setRulesAttribute($value)
    {
        $rules = $value;
        if (isset($rules['mimes']) && ! empty($rules['mimes'])) {
            foreach ($rules['mimes'] as $index => $availableExtension) {
                $rules['mimes'][$index] = Str::replace('.', '', $availableExtension);
            }
        }
        $rules['required'] = $this->required;

        $this->attributes['rules'] = json_encode($rules);
    }

    public function getRulesAttribute($value)
    {
        return json_decode($value);
    }

    public function getRuleAcceptAttribute($value)
    {
        $rules = $this->rules;
        $accept = '';
        if (isset($rules->mimes) && ! empty($rules->mimes)) {
            $accept = implode(',', array_map(
                function ($valor) {
                    return '.'.$valor;
                }, $rules->mimes));
        }

        return $accept;
    }
}
