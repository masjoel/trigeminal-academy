<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    protected $table = 'buku_tamu';
    protected $fillable = [
        'nik',
        'nama',
        'kelamin',
        'umur',
        'telepon',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'pendidikan',
        'pekerjaan',
        'instansi',
        'jabatan',
        'perangkat_desa_id',
        'keperluan',
        'foto',
    ];
    protected $casts = [
        'perangkat_desa_id' => 'array',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'desa_id');
    }
}
