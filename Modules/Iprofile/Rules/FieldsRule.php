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
       * @param  string  $attribute
       * @param  mixed  $value
       * @return bool
       */
      public function passes(string $attribute, $value): bool
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
       *
       * @return string
       */
      public function message(): string
      {
          return 'Debe aceptar los términos y condiciones';
      }
}
