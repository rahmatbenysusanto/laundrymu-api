<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class LoginUser extends FormRequest
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
            'no_hp'     => 'required',
            'password'  => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::notice('Validasi Login Failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation Login Failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
