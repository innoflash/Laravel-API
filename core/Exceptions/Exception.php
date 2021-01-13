<?php

namespace Core\Exceptions;

abstract class Exception extends \Exception
{
    abstract function getStatusCode(): int;
}
