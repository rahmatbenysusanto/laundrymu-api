<?php

namespace App\Http\Services;

use App\Http\Repository\ArtikelRepository;

class ArtikelService
{
    public function __construct(
        protected ArtikelRepository $artikelRepository
    ) {}

    public function getArtikel(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->artikelRepository->getArtikel();
    }

    public function getArtikelActive()
    {
        return $this->artikelRepository->getArtikelActive();
    }

    public function getArtikelLimit($limit)
    {
        return $this->artikelRepository->getArtikelLimit($limit);
    }

    public function buatArtikel($request): void
    {
        $this->artikelRepository->buatArtikel([
            'title'     => $request->title,
            'artike'    => $request->artikel,
            'image'     => $request->image,
            'author'    => $request->author,
            'status'    => $request->status,
            'view'      => 0
        ]);
    }
}
