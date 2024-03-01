<?php

namespace App\Http\Requests\Barang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateBarang extends FormRequest
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
            "id"    => "required",
            "nama"  => "required"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::channel('barang')->notice('Validation update barang failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation update barang failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
