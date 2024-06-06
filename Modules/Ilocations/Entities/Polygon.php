<?php

namespace Modules\Ilocations\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
  use Translatable;

  protected $table = 'ilocations__polygons';

  public $translatedAttributes = [
    'name',
    'description'
  ];

  protected $fillable = [
    'points',
    'options',
  ];

  protected $casts = [
    'options' => 'array',
    'points' => 'array',
  ];

  public function geozones()
  {
    return $this->morphToMany(Geozones::class, 'geozonable');
  }

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.polygono', $method]);

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
