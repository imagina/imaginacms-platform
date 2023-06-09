<?php

namespace Modules\Iredirect\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Iredirect\Presenters\RedirectPresenter;

class Redirect extends Model
{
    use  PresentableTrait;

    protected $table = 'iredirect__redirects';

    protected $fillable = ['from', 'to', 'redirect_type', 'options'];

    protected $presenter = RedirectPresenter::class;

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function getOptionsAttribute($value)
    {
        return json_decode(json_decode($value));
    }

    public function __call($method, $parameters)
    {
        //i: Convert array to dot notation
        $config = implode('.', ['asgard.iredirect.config.relations', $method]);

        //i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        //i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
