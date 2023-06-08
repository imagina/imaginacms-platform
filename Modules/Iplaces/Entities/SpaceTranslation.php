<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class SpaceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description','slug','meta_title','meta_description','meta_keywords'];
    protected $table = 'iplaces__space_translations';

    protected function setSummaryAttribute($value){

        if(!empty($value)){
            $this->attributes['summary'] = $value;
        } else {
            $this->attributes['summary'] = substr(strip_tags($this->attributes['description']),0,150);
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

    protected function setMetaKeywordsAttribute($value){

        if(!empty($value)){
            $this->attributes['meta_keywords'] = $value;
        } else {
            $this->attributes['meta_keywords'] =  $this->attributes['title'];
        }

    }

}
