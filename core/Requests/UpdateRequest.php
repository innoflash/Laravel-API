<?php

namespace Core\Requests;

use Core\Concerns\Requests\AuthorizesOnModel;

abstract class UpdateRequest extends SaveRequest
{
    use AuthorizesOnModel;

    public function action(): string
    {
        return 'update';
    }
}
