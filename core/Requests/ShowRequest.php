<?php

namespace Core\Requests;

use Core\Abstracts\CoreRequest;
use Core\Concerns\Requests\AuthorizesOnModel;

abstract class ShowRequest extends CoreRequest
{
    use AuthorizesOnModel;

    public function userAction(): string
    {
        return 'view';
    }
}
