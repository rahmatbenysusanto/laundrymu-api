<?php

namespace App\Http\Repository;

use App\Models\OutletPembayaran;

class OutletPembayaranRepository
{
    public function create($data): void
    {
        OutletPembayaran::create($data);
    }

    public function update($link_url, $data): void
    {
        OutletPembayaran::where('url_payment', $link_url)->update($data);
    }

    public function findByLinkUrl($link_url)
    {
        return OutletPembayaran::where('url_payment', $link_url)->first();
    }

    public function getByOutletId($outlet_id): \Illuminate\Database\Eloquent\Collection
    {
        return OutletPembayaran::with('outlet', 'lisensi')->orderBy('id', 'DESC')->where('outlet_id', $outlet_id)->get();
    }

    public function findByNomorPembayaran($nomor_pembayaran)
    {
        return OutletPembayaran::with('outlet', 'lisensi')->where('nomor_pembayaran', $nomor_pembayaran)->first();
    }
}
