<?php

namespace Core\Concerns\Requests;

use Illuminate\Support\Str;

trait ResolvesAction
{
    /**
     * Auto fetch the action from class name.
     * @return string
     */
    protected function action(): string
    {
        return Str::of(class_basename($this))
                  ->beforeLast('Request')
                  ->kebab()
                  ->__toString();
    }
}
