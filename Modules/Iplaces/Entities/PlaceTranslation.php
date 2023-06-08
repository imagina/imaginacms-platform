<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','summary','description','slug','meta_title','meta_description','meta_keywords'];
    protected $table = 'iplaces__place_translations';

    protected function setDescriptionAttribute($value){

        $this->attributes['description'] = $value;

        if(!empty($this->attributes['summary'])){
            $this->attributes['summary'] = $this->attributes['summary'];
        } else {
            $this->attributes['summary'] = isubstr(strip_tags($this->attributes['description']),150);
        }

    }

    protected function setMetaTitleAttribute($value){

        if(!empty($value)){
            $this->attributes['meta_title'] = $value;
        } else {
            $this->attributes['meta_title'] = $this->attributes['title'];
        }

    }

    protected function setMetaDescriptionAttribute($value){

        if(!empty($value)){
            $this->attributes['meta_description'] = $value;
        } else {
            $this->attributes['meta_description'] = substr(strip_tags($this->attributes['description']),0,150);
        }

    }
}
