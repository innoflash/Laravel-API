<?php

namespace Core\Requests;

use Core\Abstracts\CoreRequest;
use Core\Concerns\Requests\AuthorizesOnModel;

abstract class DeleteRequest extends CoreRequest
{
    use AuthorizesOnModel;

    public function action(): string
    {
        return 'delete';
    }
}
