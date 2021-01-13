<?php

namespace Core\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The json response for success responses.
     *
     * @param       $message
     * @param array $data
     * @param int   $statusCode
     *
     * @return mixed
     */
    public function successResponse($message, $data = [], int $statusCode = 200)
    {
        $responseData = [
            'success' => true,
            'message' => $message,
        ];

        if ($data) {
            $responseData['data'] = $data;
        }

        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
        ], $responseData), $statusCode);
    }
}
