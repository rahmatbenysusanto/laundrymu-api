<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class CreateUser extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "nama"      => "required|max:255",
            "no_hp"     => "required|max:13|unique:Users,no_hp",
            "email"     => "required|unique:Users,email",
            "role"      => "required|string",
            "password"  => "required"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::notice('Validasi Create User Failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation Create User Failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
