<?php

namespace Modules\Ifillable\Traits;

use App;
use Modules\Ifillable\Entities\Field;
use Illuminate\Support\Str;

trait isFillable
{
  /**
   * Boot trait method
   */
  public static function bootIsFillable()
  {
    //Listen event after create model
    static::createdWithBindings(function ($model) {
      //Sync schedules
      $model->syncExtraFillable($model->getEventBindings('createdWithBindings'));
    });
    //Listen event after update model
    static::updatedWithBindings(function ($model) {
      //Sync Schedules
      $model->syncExtraFillable($model->getEventBindings('updatedWithBindings'));
    });
    //Listen event after delete model
    static::deleted(function ($model) {
      $model->fields()->forceDelete();
    });
  }

  /**
   * Create schedule to entity
   */
  public function syncExtraFillable($params)
  {
    //Validate data fields
    $dataFields = $this->validateExtraFillable($params['data']);

    //Insert New fields
    foreach ($this->formatFillableToDataBase($dataFields) as $field) {
      Field::updateOrCreate(
        ['name' => $field['name'], 'entity_id' => $field['entity_id'], 'entity_type' => $field['entity_type']],
        $field
      );
    }
  }

  /**
   * Return available site locales
   */
  public function getAvailableLocales()
  {
    return array_keys(\LaravelLocalization::getSupportedLocales());
  }

  /**
   * Validate data to keep only fields to sync
   *
   * @param array $extraFields
   * @return array
   */
  public function validateExtraFillable($extraFields = [])
  {
    //Instance response
    $response = [];
    //Get model fillable
    $modelFillable = array_merge(
      $this->getFillable(),//Fillables
      $this->translatedAttributes ?? [],//Translated attributes
      array_keys($this->getRelations()),//Relations
      getIgnoredFields()//Ignored fields
    );

    //Get model translatable fields
    $modelTranslatableAttributes = $this->translatedAttributes ?? [];

    foreach ($extraFields as $keyField => $field) {
      //Validate translatable fields
      if (in_array($keyField, $this->getAvailableLocales())) {
        //Instance language in response
        $response[$keyField] = [];
        //compare with translatable attributes
        foreach ($field as $keyTransField => $transField) {
          if (!in_array($keyTransField, $modelTranslatableAttributes)) $response[$keyField][$keyTransField] = $transField;
        }
      } //Compare with model fillable and model relations
      else if (!in_array($keyField, $modelFillable) && !method_exists($this, $keyField))
        $response[$keyField] = $field;
    }

    //Response
    return $response;
  }

  /**
   * Format extra fillable to save in data base
   * @param array $extraFields
   */
  public function formatFillableToDataBase($extraFields = [])
  {
    //Instance response
    $response = [];
    //instance default morph field
    $defaultFields = ['entity_id' => $this->id, 'entity_type' => get_class($this)];

    foreach ($extraFields as $keyField => $field) {
      //Convert translatable fields
      if (in_array($keyField, $this->getAvailableLocales())) {
        foreach ($field as $keyTransField => $transField) {
          $existKeyField = array_search($keyTransField, array_column($response, 'name'));
          if ($existKeyField) $response[$existKeyField][$keyField] = ['value' => $transField];
          else $response[] = array_merge(['name' => $keyTransField, $keyField => ['value' => $transField]], $defaultFields);
        }
      } else {
        //Convert no translatable fields
        $response[] = array_merge(['name' => $keyField, 'value' => $field], $defaultFields);
      }
    }

    //Response
    return $response;
  }

  /**
   * Format fillable to response in model
   *
   * @param array $extraFields
   */
  public function formatFillableToModel($extraFields = [])
  {
    //instance response
    $response = [];
    foreach (json_decode(json_encode($extraFields)) as $extraField) {
      //Format field
      $response[Str::camel($extraField->name)] = $extraField->value;
      //Format translatable field
      foreach ($this->getAvailableLocales() as $lang) {
        if (!isset($response[$lang]) || !is_array($response[$lang])) $response[$lang] = [];
        $response[$lang][Str::camel($extraField->name)] = $extraField->{$lang}->value ?? null;
      }
    }
    //response
    return $response;
  }

  /**
   * Relation morphMany Schedules
   */
  public function fields()
  {
    return $this->morphMany(Field::class, 'entity')->with('translations');
  }
}
