<?php

namespace App\Http\Requests\User;

use App\Http\Requests\JsonRequest;

class RegisterRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'max:200'],
            "email" => ['required', 'email', 'unique:users,email', 'max:200'],
            "phone" => ['required', 'string', 'max:15'],
            "password" => ['required', 'string', 'min:8', 'confirmed'], 
        ];
    }
}
