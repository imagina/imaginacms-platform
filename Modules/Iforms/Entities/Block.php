<?php

namespace Modules\Iforms\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Block extends Model
{
    use Translatable;

    protected $table = 'iforms__blocks';
    public $translatedAttributes = [
        'title',
        'description'
    ];
    protected $fillable = [
        'form_id',
        'sort_order',
        'options',
        'name',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function fields(){
      return $this->hasMany(Field::class)->with('translations')->orderBy('order','asc');
    }

    public function getOptionsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }
}
