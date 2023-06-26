<?php

namespace Modules\Media\Validators;

use Illuminate\Contracts\Validation\Rule;

class AlphaDashWithSpaces implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     */
    public function passes(string $attribute, $value): bool
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        return preg_match('/^[\pL\pM\pN_\s-]+$/u', $value) > 0;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute may only contain letters, numbers, dashes and spaces.';
    }
}
