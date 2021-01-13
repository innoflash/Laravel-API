<?php

namespace Core\Validators;

use Core\Abstracts\CoreValidator;
use Illuminate\Support\Str;

abstract class SocialLinkValidator extends CoreValidator
{
    abstract function getLinkDomain(): string;

    /**
     * @inheritDoc
     */
    function validate($attribute, $value, $parameters, $validator): bool
    {
        return Str::of($value)->startsWith([
                'https://',
                'http://',
            ]) && Str::of($value)->contains($this->getLinkDomain());
    }

    /**
     * @inheritDoc
     */
    function message(): string
    {
        return "Invalid ". $this->alias()." social link.";
    }

    /**
     * @inheritDoc
     */
    function alias(): string
    {
        return Str::of($this->getLinkDomain())->beforeLast('.');
    }
}
