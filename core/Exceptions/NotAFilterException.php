<?php

namespace Core\Exceptions;

use Illuminate\Http\Response;

class NotAFilterException extends Exception
{
    function getStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
