<?php

namespace Core\Concerns;

use Illuminate\Support\Str;

trait FormatsName
{
    /**
     * Formats a name into title case.
     *
     * @param $name
     *
     * @return string
     */
    public function getNameAttribute($name)
    {
        return Str::title($name);
    }
}
