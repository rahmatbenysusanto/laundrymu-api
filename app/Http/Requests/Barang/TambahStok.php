<?php

namespace App\Http\Requests\Barang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class TambahStok extends FormRequest
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
            "user_id"   => "required",
            "toko_id"   => "required",
            "barang_id" => "required",
            "stok"      => "required",
            "harga"     => "required",
            "tanggal"   => "required",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::channel('barang')->notice('Validation tambah stok barang failed');
        throw new HttpResponseException(response()->json([
            "status"    => false,
            "message"   => "Validation tambah stok barang failed",
            "errors"    => $validator->errors()
        ], 422));
    }
}
