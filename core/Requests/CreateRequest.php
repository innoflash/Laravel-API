<?php

namespace Core\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

abstract class CreateRequest extends SaveRequest
{
    /**
     * Fetches the model class name.
     * @return string
     */
    abstract function getModelClassName(): string;

    /**
     * @inheritDoc
     */
    function getPolicyObject()
    {
        return $this->getModelClassName();
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException($this->authFailureMessage());
    }

    protected function authFailureMessage(): string
    {
        return 'You are not allowed to create more ' . $this->modelNamePlural() . ' right now. Consider upgrading your subscription level.';
    }

    private function modelNamePlural(): string
    {
        return Str::of($this->getModelClassName())
                  ->afterLast('\\')
                  ->lower()
                  ->plural()
                  ->__toString();
    }
}
