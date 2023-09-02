<?php

namespace Modules\Media\Validators;

use Illuminate\Contracts\Validation\Rule;

class AvailableExtensionsRule implements Rule
{
    private $extensionsAvailable;

    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($extensionsAvailable = null, $message = null)
    {
        $this->extensionsAvailable = $extensionsAvailable ?? mediaExtensionsAvailable();
        $this->message = $message ?? trans('media::messages.invalidExtensions');
    }

      /**
       * Determine if the validation rule passes.
       *
       * @param  mixed  $value
       */
      public function passes($attribute, $value)
      {
          $intersection = array_diff(is_array($value) ? $value : [$value], $this->extensionsAvailable);

          if (! empty($intersection)) {
              return false;
          } else {
              return true;
          }
      }

      /**
       * Get the validation error message.
       */
      public function message()
      {
          return $this->message;
      }
}
