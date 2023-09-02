<?php

namespace Modules\Core\Foundation\Asset\Pipeline;

use Illuminate\Support\Collection;
use Modules\Core\Foundation\Asset\AssetNotFoundException;
use Modules\Core\Foundation\Asset\Manager\AssetManager;

class AsgardAssetPipeline implements AssetPipeline
{
    /**
     * @var Collection
     */
    protected $css;

    /**
     * @var Collection
     */
    protected $js;

    public function __construct(AssetManager $assetManager)
    {
        $this->css = new Collection();
        $this->js = new Collection();
        $this->assetManager = $assetManager;
    }

    /**
     * Add a javascript dependency on the view
     *
     *
     * @throws AssetNotFoundException
     */
    public function requireJs($dependency)
    {
        if (is_array($dependency)) {
            foreach ($dependency as $dependency) {
                $this->requireJs($dependency);
            }
        }

        $assetPath = $this->assetManager->getJs($dependency);

        $this->guardForAssetNotFound($assetPath);

        $this->js->put($dependency, $assetPath);

        return $this;
    }

    /**
     * Add a CSS dependency on the view
     *
     *
     * @throws AssetNotFoundException
     */
    public function requireCss($dependency)
    {
        if (is_array($dependency)) {
            foreach ($dependency as $dependency) {
                $this->requireCss($dependency);
            }
        }

        $assetPath = $this->assetManager->getCss($dependency);

        $this->guardForAssetNotFound($assetPath);

        $this->css->put($dependency, $assetPath);

        return $this;
    }

    /**
     * Add the dependency after another one
     */
    public function after($dependency)
    {
        $this->insert($dependency, 'after');
    }

    /**
     * Add the dependency before another one
     */
    public function before($dependency)
    {
        $this->insert($dependency, 'before');
    }

    /**
     * Insert a dependency before or after in the right dependency array
     */
    private function insert($dependency, $offset = 'before')
    {
        $offset = $offset == 'before' ? 0 : 1;

        [$dependencyArray, $collectionName] = $this->findDependenciesForKey($dependency);
        [$key, $value] = $this->getLastKeyAndValueOf($dependencyArray);

        $pos = $this->getPositionInArray($dependency, $dependencyArray);

        $dependencyArray = array_merge(
            array_slice($dependencyArray, 0, $pos + $offset, true),
            [$key => $value],
            array_slice($dependencyArray, $pos, count($dependencyArray) - 1, true)
        );

        $this->$collectionName = new Collection($dependencyArray);
    }

    /**
     * Return all css files to include
     */
    public function allCss()
    {
        return $this->css;
    }

    /**
     * Return all js files to include
     */
    public function allJs()
    {
        return $this->js;
    }

    /**
     * Find in which collection the given dependency exists
     */
    private function findDependenciesForKey($dependency)
    {
        if ($this->css->get($dependency)) {
            return [$this->css->toArray(), 'css'];
        }

        return [$this->js->toArray(), 'js'];
    }

    /**
     * Get the last key and value the given array
     */
    private function getLastKeyAndValueOf(array $dependencyArray)
    {
        $value = end($dependencyArray);
        $key = key($dependencyArray);
        reset($dependencyArray);

        return [$key, $value];
    }

    /**
     * Return the position in the array of the given key
     */
    private function getPositionInArray($dependency, array $dependencyArray)
    {
        $pos = array_search($dependency, array_keys($dependencyArray));

        return $pos;
    }

    /**
     * If asset was not found, throw an exception
     *
     *
     * @throws AssetNotFoundException
     */
    private function guardForAssetNotFound($assetPath)
    {
        if (is_null($assetPath)) {
            throw new AssetNotFoundException($assetPath);
        }
    }
}
