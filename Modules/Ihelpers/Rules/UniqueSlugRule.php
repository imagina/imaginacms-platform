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

    public $message;

    public function __construct($table, $id = null, $columnId = '', $message = '')
    {
        $this->table = $table;
        $this->id = $id;
        $this->columnId = $columnId;
        $this->message = ! empty($message) ? $message : 'There are another register with the same slug-locale.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     */
    public function passes(string $attribute, $value): bool
    {
        $explodeAttributes = explode('.', $attribute);
        $slugs = \DB::table($this->table)
          ->where($explodeAttributes[1], $value)
          ->where('locale', $explodeAttributes[0]);

        if ($this->id) {
            $slugs = $slugs->where($this->columnId, '!=', $this->id);
        }

        $slugs = $slugs->first();

        return ! $slugs;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return $this->message;
    }
}
