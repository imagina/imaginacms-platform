<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class Geozones extends Model
{


    protected $table = 'ilocations__geozones';

    protected $fillable = [
        'name',
        'description'
    ];

    public function countries()
    {
        return $this->morphedByMany(Country::Class, 'geozonable', 'ilocations__geozonables', 'geozone_id', 'geozonable_id');
    }

    public function cities()
    {
        return $this->morphedByMany(City::Class, 'geozonable', 'ilocations__geozonables', 'geozone_id');
    }

    public function provinces()
    {
        return $this->morphedByMany(Province::Class, 'geozonable', 'ilocations__geozonables', 'geozone_id');
    }

    public function polygons()
    {
        return $this->morphedByMany(Polygon::Class, 'geozonable', 'ilocations__geozonables', 'geozone_id');
    }

    public function neighborhoods()
    {
        return $this->morphedByMany(Neighborhood::Class, 'geozonable', 'ilocations__geozonables', 'geozone_id');
    }

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.geozones', $method]);

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
