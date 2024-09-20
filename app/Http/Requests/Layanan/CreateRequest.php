<?php

namespace App\Http\Requests\Layanan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'outlet_id' => 'required|exists:outlet,id',
            'nama'      => 'required|string',
            'type'      => 'required|string',
            'harga'     => 'required|numeric',
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
