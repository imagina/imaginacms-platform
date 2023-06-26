<?php

namespace Modules\Ihelpers\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueRule implements Rule
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
        $this->message = ! empty($message) ? $message : 'There are another register with the same email.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     */
    public function passes(string $attribute, $value): bool
    {
        $explodeAttributes = explode('.', $attribute);

        $items = \DB::connection(env('DB_CONNECTION', 'mysql'))->table($this->table)
          ->where($explodeAttributes[0], $value);

        if ($this->id) {
            $items = $items->where($this->columnId, '!=', $this->id);
        }

        $items = $items->first();

        return ! $items;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return $this->message;
    }
}
