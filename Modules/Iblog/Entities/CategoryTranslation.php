<?php

namespace Modules\Iblog\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $table = 'iblog__category_translations';
    protected $fillable = ['title', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'translatable_options'];

    protected $casts = [
        'translatable_options' => 'array'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
       public function sluggable()
       {
           return [
               'slug' => [
                   'source' => 'title'
               ]
        ];
       }
    public function getMetaDescriptionAttribute(){

        return $this->meta_description ?? substr(strip_tags($this->description??''),0,150);
    }
    public function getTranslatableOptionAttribute($value) {

        $options=json_decode($value);
        return $options;


    }

    /**
     * @return mixed
     */
    public function getMetaTitleAttribute(){

        return $this->meta_title ?? $this->title;
    }


}
