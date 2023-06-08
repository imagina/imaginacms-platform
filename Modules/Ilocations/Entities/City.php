<?php

namespace Modules\Ilocations\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class City extends Model
{
    use Translatable;

    protected $table = 'ilocations__cities';
    public $translatedAttributes = [
        'name'
    ];
    protected $fillable = [
        'code',
        'province_id',
        'country_id'
    ];
  
  public function __construct(array $attributes = [])
  {
   
    parent::__construct($attributes);
  }
  
  public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function geozones()
    {
        return $this->morphToMany(Geozones::class, 'geozonable');
    }
  
  public function getNameAttribute(){
    
    $currentTranslations = $this->getTranslation(locale());
    
    if (empty($currentTranslations) || empty($currentTranslations->toArray()["name"])) {
      
      $model = $this->getTranslation(\LaravelLocalization::getDefaultLocale());
      
      if(empty($model)) return "";
      return $model->toArray()["name"] ?? "";
    }
    
    return $currentTranslations->toArray()["name"];
    
  }
    
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.city', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            $bound = $function->bindTo($this);

            return $bound();
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
