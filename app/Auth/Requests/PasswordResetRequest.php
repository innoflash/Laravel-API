<?php

namespace App\Auth\Requests;

use Core\Abstracts\CoreRequest;

class PasswordResetRequest extends CoreRequest
{
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * @inheritDoc
     */
    function rules(): array
    {
        return [
            'password' => 'required|between:6,255|confirmed',
        ];
    }
}
