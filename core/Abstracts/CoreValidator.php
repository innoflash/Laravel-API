<?php

namespace Core\Abstracts;

use Illuminate\Validation\Rule;

abstract class CoreValidator extends Rule
{
    /**
     * The validation logic.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    abstract function validate($attribute, $value, $parameters, $validator): bool;

    /**
     * Validation failure message.
     * @return string
     */
    abstract function message(): string;

    /**
     * Validation alias.
     * @return string
     */
    abstract function alias(): string;
}
