<?php

namespace Dev\Exceptions;

class NoModuleSetException extends \Exception
{
    protected $message = 'You need to set a module first.';
}
