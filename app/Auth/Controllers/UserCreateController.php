<?php

namespace App\Auth\Controllers;

use Core\Models\User;
use Illuminate\Http\Response;
use Core\Controllers\Controller;
use Core\Resources\UserResource;
use App\Auth\Requests\UserCreateRequest;
use Core\Contracts\Services\UserCommandService;

class UserCreateController extends Controller
{
    /**
     * Creates the user and log them in.
     *
     * @param UserCreateRequest  $request
     * @param UserCommandService $userCommandService
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserCreateRequest $request, UserCommandService $userCommandService)
    {
        $user = $request->map(User::class);
        $user->makeVisible('password');

        $user = $userCommandService->create($user);

        if (!$token = auth()->login($user)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unknown error occured.');
        }

        return response()->json([
            'user'  => new UserResource($user),
            'token' => [
                'access_token' => $token,
                'expires_in'   => auth()->factory()->getTTL() * 60,
                'type'         => 'bearer',
            ],
        ]);
    }
}
