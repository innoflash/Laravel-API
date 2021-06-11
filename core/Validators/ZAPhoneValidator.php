<?php

namespace Core\Validators;

use Core\Abstracts\CoreValidator;
use Illuminate\Support\Str;

class ZAPhoneValidator extends CoreValidator
{
    public function validate($attribute, $value, $parameters, $validator): bool
    {
        if (strlen($value) < 10) {
            return false;
        }

        $valStr = Str::of($value);

        $number = $valStr->after('0');

        if ($valStr->startsWith(['+27', '0027', '27'])) {
            $number = $valStr->after('27');
        } else {
            if (! $valStr->startsWith('0')) {
                return false;
            }
        }

        if (strlen($number) < 9) {
            return false;
        }

        $valInt = (int) $number->__toString();

        if (is_numeric($valInt)) {
            if ($valInt < 610000001) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    function message(): string
    {
        return 'The :attribute given is not a valid South African cell number';
    }

    /**
     * @inheritDoc
     */
    function alias(): string
    {
        return 'za_number';
    }
}
