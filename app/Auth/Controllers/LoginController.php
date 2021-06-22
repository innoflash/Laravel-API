<?php

namespace App\Auth\Controllers;

use Illuminate\Http\Response;
use Core\Controllers\Controller;
use Core\Resources\UserResource;
use App\Auth\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * Logs in the admin.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            abort(Response::HTTP_UNAUTHORIZED, 'Invalid login password.');
        }

        return response()->json([
            'user'  => new UserResource(auth()->user()),
            'token' => [
                'access_token' => $token,
                'expires_in'   => auth()->factory()->getTTL() * 60,
                'type'         => 'bearer',
            ],
        ]);
    }
}
