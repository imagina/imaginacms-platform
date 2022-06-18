<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
  const TEXT = 1;
  const TEXTAREA = 2;
  const NUMBER = 3;
  const EMAIL = 4;
  const SELECT = 5;
  const SELECT_MULTIPLE = 6;
  const CHECKBOX = 7;
  const RADIO = 8;
  const LOCATION = 9;
  const PHONE = 10;
  const DATE = 11;
  const FILE = 12;
  const TREE_SELECT = 13;
  const HIDDEN = 14;

  /**
   * @var array
   */
  private $types = [];

  public function __construct()
  {
    $this->types = [
      [
        'id' => self::TEXT,
        'name' => trans('iforms::common.types.text'),
        'value' => 'text'
      ],
      [
        'id' => self::TEXTAREA,
        'name' => trans('iforms::common.types.textarea'),
        'value' => 'textarea'
      ],
      [
        'id' => self::NUMBER,
        'name' => trans('iforms::common.types.number'),
        'value' => 'number'
      ],
      [
        'id' => self::EMAIL,
        'name' => trans('iforms::common.types.email'),
        'value' => 'email'
      ],
      [
        'id' => self::SELECT,
        'name' => trans('iforms::common.types.select'),
        'value' => 'select'
      ],
      [
        'id' => self::SELECT_MULTIPLE,
        'name' => trans('iforms::common.types.selectmultiple'),
        'value' => 'selectmultiple'
      ],
      [
        'id' => self::CHECKBOX,
        'name' => trans('iforms::common.types.checkbox'),
        'value' => 'checkbox'
      ],
      [
        'id' => self::RADIO,
        'name' => trans('iforms::common.types.radio'),
        'value' => 'radio'
      ],
      [
        'id' => self::LOCATION,
        'name' => trans('iforms::common.types.location'),
        'value' => 'location'
      ],
      [
        'id' => self::PHONE,
        'name' => trans('iforms::common.types.phone'),
        'value' => 'phone'
      ],
      [
        'id' => self::DATE,
        'name' => trans('iforms::common.types.date'),
        'value' => 'date'
      ],
      [
        'id' => self::FILE,
        'name' => trans('iforms::common.types.file'),
        'value' => 'file'
      ],
      [
        'id' => self::TREE_SELECT,
        'name' => trans('iforms::common.types.treeSelect'),
        'value' => 'treeSelect'
      ],
      [
        'id' => self::HIDDEN,
        'name' => trans('iforms::common.types.hidden'),
        'value' => 'hidden'
      ],
    ];
  }

  /**
   * Get the available statuses
   * @return array
   */
  public function lists()
  {
    return $this->types;
  }

  /**
   * Get the post status
   * @param int $id
   * @return string
   */
  public function get($id)
  {
    $id--;
    if (isset($this->types[$id])) {
      return $this->types[$id];
    }
    return $this->types[0];
  }
}
