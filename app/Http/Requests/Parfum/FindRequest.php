<?php

namespace App\Http\Requests\Parfum;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FindRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'        => 'nullable|numeric|required_without:outlet_id',
            'outlet_id' => 'nullable|numeric|required_without:id'
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
