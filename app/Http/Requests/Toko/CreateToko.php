<?php

namespace App\Http\Requests\Toko;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class CreateToko extends FormRequest
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
            "user_id"       => "required",
            "nama"          => "required",
            "alamat"        => "required",
            "provinsi"      => "required",
            "kabupaten"     => "required",
            "kecamatan"     => "required",
            "kelurahan"     => "required",
            "kode_pos"      => "required",
//            "lat"           => "required",
//            "long"          => "required",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::notice('Validation create toko failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation create toko failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
