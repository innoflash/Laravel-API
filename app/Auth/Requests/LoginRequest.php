<?php

namespace App\Auth\Requests;

use Core\Abstracts\CoreRequest;

class LoginRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    function rules(): array
    {
        return [
            'email'    => 'required|email|exists:users',
            'password' => 'required|string|min:6'
        ];
    }
}
