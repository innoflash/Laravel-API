<?php

namespace App\Auth\Controllers;

use Core\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Logs out the user.
     * @return mixed
     */
    public function __invoke()
    {
        auth()->logout();

        return $this->successResponse('Logged out successfully.');
    }
}
