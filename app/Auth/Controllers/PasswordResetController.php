<?php

namespace App\Auth\Controllers;

use Core\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Auth\Requests\PasswordResetRequest;

class PasswordResetController extends Controller
{
    public function __invoke(PasswordResetRequest $request)
    {
        auth('web')->user()
                   ->update([
                       'password' => Hash::make($request->password)
                   ]);

        auth('web')->logout();

        return redirect()
            ->route('response.success')
            ->with('success', 'Password changed successfully');
    }
}
