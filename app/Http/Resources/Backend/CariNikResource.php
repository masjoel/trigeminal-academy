<?php

namespace App\Http\Resources\SID;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CariNikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'nik' => $this->nik,
            'paspor' => $this->paspor,
            'nama' => $this->nama,
            'gender' => $this->gender,
            'tgl_lahir' => $this->tgl_lahir,
            'pendidikan' => $this->pendidikan,
            'pekerjaan' => $this->pekerjaan,
            'hubungan' => $this->hubungan,
            'jkn' => $this->jkn,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'status' => $this->status,
        ];
    }
}
