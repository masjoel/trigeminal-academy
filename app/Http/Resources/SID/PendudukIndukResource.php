<?php

namespace App\Http\Resources\SID;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;

class PendudukIndukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $attributes = $this->attributesToArray();
        if (isset($attributes['id_ktp'])) {
            $attributes['id_ktp'] = Crypt::decryptString($attributes['id_ktp']);
        }
        if (isset($attributes['nik'])) {
            $attributes['nik'] = Crypt::decryptString($attributes['nik']);
        }
        if (isset($attributes['kk'])) {
            $attributes['kk'] = Crypt::decryptString($attributes['kk']);
        }
        return $attributes;
    }
}
