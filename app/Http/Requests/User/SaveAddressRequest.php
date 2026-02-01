<?php

namespace App\Http\Requests\User;

use App\Http\Requests\JsonRequest;

class SaveAddressRequest extends JsonRequest
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
            "name" => ['required', 'string', 'max:150'],
            "city" => ['required', 'string', 'max:50'],
            "full_address" => ['required', 'string'],
            "is_default" => ['boolean'],
        ];
    }
}
