<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
            'outlet_id'         => 'required|integer|exists:outlet,id',
            'pelanggan_id'      => 'required|integer|exists:pelanggan,id',
            'diskon_id'         => 'nullable|integer|exists:diskon,id',
            'pengiriman_id'     => 'nullable|integer|exists:pengiriman,id',
            'pembayaran_id'     => 'required|integer|exists:pembayaran,id',
            'status'            => 'required|string',
            'status_pembayaran' => 'required|string|in:lunas,belum lunas, pending',
            'harga'             => 'required|numeric|min:0',
            'harga_diskon'      => 'nullable|numeric|min:0',
            'biaya_pengiriman'  => 'nullable|numeric|min:0',
            'total_harga'       => 'required|numeric|min:0',
            'catatan'           => 'nullable|string|max:255',
            'detail'            => 'required|array',
            'detail.*.layanan_id'   => 'required|integer|exists:layanan,id',
            'detail.*.parfum_id'    => 'required|integer|exists:parfum,id',
            'detail.*.jumlah'       => 'required|integer|min:1',
            'detail.*.harga'        => 'required|numeric|min:0',
            'detail.*.total_harga'  => 'required|numeric|min:0',
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
