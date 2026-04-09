<?php

namespace NettSite\Messenger\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'fcm_token' => ['nullable', 'string'],
            'platform' => ['required', 'string', 'in:android,ios,web'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::debug('Messenger login validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->except(['password']),
        ]);

        throw new ValidationException($validator);
    }
}
