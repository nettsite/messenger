<?php

namespace NettSite\Messenger\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'fcm_token' => ['required', 'string'],
            'platform' => ['required', 'string', 'in:android,ios'],
        ];
    }
}
