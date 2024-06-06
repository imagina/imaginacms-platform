<?php

namespace Modules\Ilocations\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use Translatable;

    protected $table = 'ilocations__neighborhoods';
    public $translatedAttributes = ["name"];
    protected $fillable = ["city_id"];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

  public function geozones()
  {
    return $this->morphToMany(Geozones::class, 'geozonable');
  }
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.neighborhood', $method]);

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
