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
       * @param  string  $attribute
       * @param  mixed  $value
       * @return bool
       */
      public function passes(string $attribute, $value): bool
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
       *
       * @return string
       */
      public function message(): string
      {
          return $this->message;
      }
}
