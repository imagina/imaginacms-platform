<?php

namespace Modules\Ihelpers\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueSlugRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $table;
    public $id;
    public $columnId;
    
    public function __construct($table, $id = null, $columnId = "")
    {
      $this->table = $table;
      $this->id = $id;
      $this->columnId = $columnId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
  
      $explodeAttributes = explode(".",$attribute);
      $slugs = \DB::connection(env('DB_CONNECTION', 'mysql'))->table($this->table)
        ->where($explodeAttributes[1],$value)
        ->where('locale',$explodeAttributes[0]);
      
      if($this->id){
        $slugs = $slugs->where($this->columnId, "!=", $this->id);
      }

      $slugs = $slugs->first();
      return !$slugs;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There are another register with the same slug-locale.';
    }
}
