<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'          => 'required|string|between:2,100',
            'no_hp'         => 'required|string|size:13',
            'email'         => 'required|string|email|max:100|unique:users',
            'password'      => 'required|string|min:6',
            'nama_outlet'   => 'required|string|between:2,100',
            'no_hp_outlet'  => 'required|string|size:13',
        ];
    }

    private function response($err): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status'    => false,
            'message'   => 'Validation Request Failed',
            'errors'    => $err
        ], 422);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response($validator->errors()));
    }
}
