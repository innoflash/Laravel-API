<?php

namespace Core\Exceptions;

use Illuminate\Http\Response;

class CoreInternalErrorException extends Exception
{

    function getStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
