<?php

namespace App\Auth\Controllers;

use Core\Controllers\Controller;
use App\Auth\Requests\ForgotPasswordRequest;
use Core\Contracts\Repositories\UserRepository;
use App\Auth\Notifications\ForgotPasswordNotification;

class ForgotPasswordController extends Controller
{
    /**
     * Emails a forgot password link to user.
     *
     * @param ForgotPasswordRequest $request
     * @param UserRepository        $userRepository
     *
     * @return mixed
     */
    public function __invoke(ForgotPasswordRequest $request, UserRepository $userRepository)
    {
        $userRepository->findByField('email', $request->email)
                       ->first()
                       ->notify(new ForgotPasswordNotification());

        return $this->successResponse('Password reset request sent, please check your email to change it');
    }
}
