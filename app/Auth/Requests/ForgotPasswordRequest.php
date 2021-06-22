<?php

namespace App\Auth\Requests;

use Core\Abstracts\CoreRequest;

class ForgotPasswordRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * The rules for creating a user.
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }
}
