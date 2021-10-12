<?php

namespace Modules\Core\Support\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait AuditTrait
{
  use SoftDeletes;

  /**
   *
   * @param bool
   */
  public $userstamping = true;

  public static function bootAuditTrait()
  {
    /**
     * add created_by and updated_by field to model fillable
     *
     */
    static::retrieved(function ($model) {
      $model->fillable = array_merge($model->fillable, [$model->getCreatedByColumn(), $model->getUpdatedBycolumn()]);
    });

    //event before create model
    static::creating(function ($model) {
      if (!$model->isUserstamping() || is_null($model->getCreatedByColumn())) {
        return;
      }

      if (is_null($model->{$model->getCreatedByColumn()})) {
        $model->{$model->getCreatedByColumn()} = \Auth::id();
      }

      if (is_null($model->{$model->getUpdatedByColumn()}) && !is_null($model->getUpdatedByColumn())) {
        $model->{$model->getUpdatedByColumn()} = \Auth::id();
      }
    });

    //event before update model
    static::updating(function ($model) {
      if (!$model->isUserstamping() || is_null($model->getUpdatedByColumn()) || is_null(\Auth::id())) {
        return;
      }

      if (is_null($model->{$model->getCreatedByColumn()})) {
        $model->{$model->getCreatedByColumn()} = \Auth::id();
      }

      $model->{$model->getUpdatedByColumn()} = \Auth::id();
    });

    if (static::usingSoftDeletes()) {
      static::deleting(function ($model) {
        if (!$model->isSoftDeleting() || is_null($model->getDeletedByColumn())) {
          return;
        }

        if (is_null($model->{$model->getDeletedByColumn()})) {
          $model->{$model->getDeletedByColumn()} = \Auth::id();
        }

        $dispatcher = $model->getEventDispatcher();

        $model->unsetEventDispatcher();

        $model->save();

        $model->setEventDispatcher($dispatcher);
      });
      static::restoring(function ($model) {

        if (!$model->isSoftDeleting() || is_null($model->getDeletedByColumn())) {
          return;
        }

        $model->{$model->getDeletedByColumn()} = null;
      });
    }
  }

  /**
   * Has the model loaded the SoftDeletes trait.
   *
   * @return bool
   */
  public static function usingSoftDeletes()
  {
    static $usingSoftDeletes;

    if (is_null($usingSoftDeletes)) {
      return $usingSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(get_called_class()));
    }

    return $usingSoftDeletes;
  }

  /**
   * Get the name of the "created by" column.
   *
   * @return string
   */
  public function getCreatedByColumn()
  {
    return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
  }

  /**
   * Get the name of the "updated by" column.
   *
   * @return string
   */
  public function getUpdatedByColumn()
  {
    return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
  }

  /**
   * Get the name of the "deleted by" column.
   *
   * @return string
   */
  public function getDeletedByColumn()
  {
    return defined('static::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
  }

  /**
   * Get the user that created the model.
   */
  public function creator()
  {
    return $this->belongsTo($this->getUserClass(), $this->getCreatedByColumn());
  }

  /**
   * Get the user that edited the model.
   */
  public function editor()
  {
    return $this->belongsTo($this->getUserClass(), $this->getUpdatedByColumn());
  }

  /**
   * Get the user that deleted the model.
   */
  public function destroyer()
  {
    return $this->belongsTo($this->getUserClass(), $this->getDeletedByColumn());
  }


  public function getUserClass()
  {
    $driver = config('asgard.user.config.driver');
    return "Modules\\User\\Entities\\{$driver}\\User";
  }

  /**
   * Check if we're maintaing Userstamps on the model.
   *
   * @return bool
   */
  public function isUserstamping()
  {
    return $this->userstamping;
  }

  /**
   * Check if we're maintaing Userstamps on the model.
   *
   * @return bool
   */
  public function isSoftDeleting()
  {
    return true;//$this->softdeleting ?? false;
  }
}
