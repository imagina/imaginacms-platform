<?php

namespace Modules\Iprofile\Rules;

use Illuminate\Contracts\Validation\Rule;

class FieldsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $setting;

    public function __construct()
    {
        $this->setting = app('Modules\Setting\Contracts\Setting');
    }

      /**
       * Determine if the validation rule passes.
       *
       * @param  mixed  $value
       */
      public function passes($attribute, $value)
      {
          foreach ($value as $fieldName => $fieldValue) {
              if ($this->setting->get('iprofile::registerUserWithPoliticsOfPrivacy')) {
                  if ($fieldName == 'confirmPolytics' && ! $fieldValue) {
                      return false;
                  }
              }
          }

          return true;
      }

      /**
       * Get the validation error message.
       */
      public function message()
      {
          return 'Debe aceptar los términos y condiciones';
      }
}
