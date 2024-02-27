<?php

namespace App\Http\Repository;

use App\Models\Artikel;

class ArtikelRepository
{
    public function getArtikel(): \Illuminate\Database\Eloquent\Collection
    {
        return Artikel::all();
    }

    public function getArtikelActive()
    {
        return Artikel::where('status', 'active')->get();
    }

    public function getArtikelLimit($limit)
    {
        return Artikel::where('status', 'active')
            ->limit($limit)
            ->get();
    }

    public function buatArtikel($data): void
    {
        Artikel::create($data);
    }
}
