<?php

namespace Modules\Ihelpers\Traits;

trait Relationable
{
    /**
     * Magic Method modification to allow dynamic relations to other entities.
     *
     *
     * @var
     * @var
     */
    public function __call($method, $parameters)
    {
        $classNamespace = get_class($this);
        $classNamespaceExploded = explode('\\', strtolower($classNamespace));

        //i: Convert array to dot notation
        $config = implode('.', ['asgard.'.$classNamespaceExploded[1].'.config.relations.'.$classNamespaceExploded[3], $method]);

        //i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            $bound = $function->bindTo($this);

            return $bound();
        }

        //i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
