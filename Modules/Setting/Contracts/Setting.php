<?php

namespace Modules\Setting\Contracts;

interface Setting
{
    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Get the specified configuration value in the given language
     *
     * @param  string  $key
     * @param  string  $locale
     * @param  mixed  $default
     * @return string
     */
    public function get(string $key, string $locale = null, string $default = null);

    /**
     * Set a given configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return \Modules\Setting\Entities\Setting
     */
    public function set(string $key, $value);
}
