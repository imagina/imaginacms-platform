<?php

namespace Modules\Core\Icrud\Traits;

trait hasEventsWithBindings
{
    /**
     * Save event bindings
     *
     * @var array
     */
    public $eventBindings = [];

    /**
     * Boot trait method
     */
    public static function bootHasEventsWithBindings()
    {
    }

    //=== Catch fire model events with bindings

    /**
     * Re-write method to Fire the given event for the model.
     *
     * @param  array  $data
     * @return mixed
     */
    protected function fireModelEvent(string $event, bool $halt = true, array $bindings = [])
    {
        //Save Event bindings
        $this->eventBindings[$event] = $bindings;
        //fire parent method
        return parent::fireModelEvent($event, $halt);
    }

    /**
     * Get the event bindings by event name
     */
    public function getEventBindings(string $event): ?array
    {
        //Add data to eventData
        if (array_key_exists($event, $this->eventBindings)) {
            return $this->eventBindings[$event];
        }

        //Default response
        return null;
    }

    //=== Register model events with bindings

    /**
     * Register event to moel was retrieved
     */
    public static function retrievedIndexWithBindings($callback): void
    {
        static::registerModelEvent('retrievedIndexWithBindings', $callback);
    }

    /**
     * Register event to moel was retrieved
     */
    public static function retrievedShowWithBindings($callback): void
    {
        static::registerModelEvent('retrievedShowWithBindings', $callback);
    }

    /**
     * Register event to before create model
     *
     * @param  \Closure|string  $callback
     */
    public static function creatingWithBindings($callback): void
    {
        static::registerModelEvent('creatingWithBindings', $callback);
    }

    /**
     * Register event to after create model
     *
     * @param  \Closure|string  $callback
     */
    public static function createdWithBindings($callback): void
    {
        static::registerModelEvent('createdWithBindings', $callback);
    }

    /**
     * Register event to before update model
     *
     * @param  \Closure|string  $callback
     */
    public static function updatingWithBindings($callback): void
    {
        static::registerModelEvent('updatingWithBindings', $callback);
    }

    /**
     * Register event to after update model
     *
     * @param  \Closure|string  $callback
     */
    public static function updatedWithBindings($callback): void
    {
        static::registerModelEvent('updatedWithBindings', $callback);
    }

    //=== Event handlers with bindings

    /**
     * Method to fire event when model was retrieved
     */
    public function retrievedIndexCrudModel($bindings = []): void
    {
        // fire custom event on the model
        $this->fireModelEvent('retrievedIndexWithBindings', false, $bindings);
    }

    /**
     * Method to fire event when model was retrieved
     */
    public function retrievedShowCrudModel($bindings = []): void
    {
        // fire custom event on the model
        $this->fireModelEvent('retrievedShowWithBindings', false, $bindings);
    }

    /**
     * Method to fire event before create model
     */
    public function creatingCrudModel($bindings = [])
    {
        // fire custom event on the model
        $this->fireModelEvent('creatingWithBindings', false, $bindings);
    }

    /**
     * Method to fire event after create model
     */
    public function createdCrudModel($bindings = [])
    {
        // fire custom event on the model
        $this->fireModelEvent('createdWithBindings', false, $bindings);
    }

    /**
     * Method to fire event before update model
     */
    public function updatingCrudModel($bindings = [])
    {
        // fire custom event on the model
        $this->fireModelEvent('updatingWithBindings', false, $bindings);
    }

    /**
     * Method to fire event after update model
     */
    public function updatedCrudModel($bindings = [])
    {
        // fire custom event on the model
        $this->fireModelEvent('updatedWithBindings', false, $bindings);
    }
}
