<?php

namespace Core\Concerns;

use Core\Abstracts\CoreValidator;
use Illuminate\Support\Facades\Validator;

trait RegistersValidationRules
{
    /**
     * Registers validation rules.
     */
    protected function registerValidationRules()
    {
        foreach ($this->validationRules as $rule) {
            $validator = new $rule();
            if ($validator instanceof CoreValidator) {
                Validator::extend($validator->alias(), $rule, $validator->message());
            }
        }
    }
}
