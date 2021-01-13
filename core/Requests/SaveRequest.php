<?php

namespace Core\Requests;

use Core\Abstracts\CoreRequest;
use Core\Concerns\Requests\ResolvesAction;

abstract class SaveRequest extends CoreRequest
{
    use ResolvesAction;

    /**
     * The item to test again the policy.
     * @return mixed
     */
    abstract function getPolicyObject();

    /**
     * The error message to sent back to the user on failure.
     * @return string
     */
    abstract protected function authFailureMessage(): string;

    public function authorize()
    {
        return $this->user()->can($this->action(), $this->getPolicyObject());
    }
}
