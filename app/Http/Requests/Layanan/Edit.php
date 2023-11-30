<?php

namespace App\Http\Requests\Layanan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class Edit extends FormRequest
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
            "toko_id"   => "required",
            "nama"      => "required",
            "type"      => "required",
            "harga"     => "required"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::notice('Validation edit layanan failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation edit layanan failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
