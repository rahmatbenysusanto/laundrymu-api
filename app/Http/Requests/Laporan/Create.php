<?php

namespace App\Http\Requests\Laporan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class Create extends FormRequest
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
            'user_id'   => 'required',
            'kategori'  => 'required',
            'laporan'   => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::notice('Validation create diskon failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation create laporan failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
