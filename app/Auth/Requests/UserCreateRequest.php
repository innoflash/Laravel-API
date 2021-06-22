<?php

namespace App\Auth\Requests;

use Core\Abstracts\CoreRequest;

class UserCreateRequest extends CoreRequest
{
    public function authorize(): bool
    {
        return true;
    }


    function rules(): array
    {
        return [
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
        ];
    }
}
