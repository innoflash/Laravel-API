<?php

namespace Core\Exceptions;

use Core\Concerns\ExceptionsTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ExceptionsTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (Throwable $e, Request $request) {
            if ($e instanceof PostTooLargeException) {
                return response()->json([
                    'exception'  => PostTooLargeException::class,
                    'statusCode' => Response::HTTP_REQUEST_ENTITY_TOO_LARGE,
                    'message'    => 'Post content too large',
                ], $e->getStatusCode());
            }
            if ($request->route() && in_array('api', $request->route()->gatherMiddleware())) {
                return $this->apiExceptions($request, $e);
            }
        });
    }
}
