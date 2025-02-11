<?php

namespace App\Http\Resources\SID;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratKategoriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'kode' => $this->kode,
        //     'kategori' => $this->kategori,
        //     'created_at' => $this->created_at,
        // ];
    }
}
