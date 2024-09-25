<?php

namespace App\Http\Requests\Outlet;

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
            'user_id'   => 'nullable|numeric|required_without:outlet_id',
            'outlet_id' => 'nullable|numeric|required_without:user_id'
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
