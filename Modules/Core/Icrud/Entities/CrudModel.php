<?php

namespace Modules\Core\Icrud\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;

class CrudModel extends Model
{
  use AuditTrait;

  /**
   * Save event bindings
   * @var array
   */
  public $eventBindings = [];

  //=== Catch fire model events with bindings

  /**
   * Re-write method to Fire the given event for the model.
   *
   * @param string $event
   * @param bool $halt
   * @param array $data
   * @return mixed
   */
  protected function fireModelEvent($event, $halt = true, array $bindings = [])
  {
    //Save Event bindings
    $this->eventBindings[$event] = $bindings;
    //fire parent method
    return parent::fireModelEvent($event, $halt);
  }

  /**
   * Get the event bindings by event name
   *
   * @param string $event
   * @return array|NULL
   */
  public function getEventBindings(string $event)
  {
    //Add data to eventData
    if (array_key_exists($event, $this->eventBindings)) {
      return $this->eventBindings[$event];
    }

    //Default response
    return NULL;
  }

  //=== Register model events with bindings

  /**
   * Register event to before create model
   *
   * @param \Closure|string $callback
   * @return void
   */
  public static function creatingWithBindings($callback)
  {
    static::registerModelEvent('creatingWithBindings', $callback);
  }

  /**
   * Register event to after create model
   *
   * @param \Closure|string $callback
   * @return void
   */
  public static function createdWithBindings($callback)
  {
    static::registerModelEvent('createdWithBindings', $callback);
  }

  /**
   * Register event to before update model
   *
   * @param \Closure|string $callback
   * @return void
   */
  public static function updatingWithBindings($callback)
  {
    static::registerModelEvent('updatingWithBindings', $callback);
  }

  /**
   * Register event to after update model
   *
   * @param \Closure|string $callback
   * @return void
   */
  public static function updatedWithBindings($callback)
  {
    static::registerModelEvent('updatedWithBindings', $callback);
  }

  //=== Event handlers with bindings

  /**
   * Method to fire event before create model
   *
   * @param $bindings
   */
  public function creatingCrudModel($bindings = [])
  {
    // fire custom event on the model
    $this->fireModelEvent('creatingWithBindings', false, $bindings);
  }

  /**
   * Method to fire event after create model
   *
   * @param $bindings
   */
  public function createdCrudModel($bindings = [])
  {
    // fire custom event on the model
    $this->fireModelEvent('createdWithBindings', false, $bindings);
  }

  /**
   * Method to fire event before update model
   *
   * @param $bindings
   */
  public function updatingCrudModel($bindings = [])
  {
    // fire custom event on the model
    $this->fireModelEvent('updatingWithBindings', false, $bindings);
  }

  /**
   * Method to fire event after update model
   *
   * @param $bindings
   */
  public function updatedCrudModel($bindings = [])
  {
    // fire custom event on the model
    $this->fireModelEvent('updatedWithBindings', false, $bindings);
  }
}
