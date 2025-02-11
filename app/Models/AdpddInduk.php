<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdpddInduk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $encrypted = ['id_ktp', 'nik', 'kk'];

    // public function getAttribute($key)
    // {
    //     if (in_array($key, $this->encrypted)) {
    //         try {
    //             return Crypt::decryptString($this->attributes[$key]);
    //         } catch (\Exception $e) {
    //             return 'Data tidak valid';
    //         }
    //     }

    //     return parent::getAttribute($key);
    // }
    // public function setIdKtpAttribute($value)
    // {
    //     $this->attributes['hash_id_ktp'] = hash('sha256', $value);
    //     $this->attributes['id_ktp'] = Crypt::encryptString($value);
    // }
    // public function setNikAttribute($value)
    // {
    //     $this->attributes['hash_nik'] = hash('sha256', $value);
    //     $this->attributes['nik'] = Crypt::encryptString($value);
    // }
    // public function setKkAttribute($value)
    // {
    //     $this->attributes['hash_kk'] = hash('sha256', $value);
    //     $this->attributes['kk'] = Crypt::encryptString($value);
    // }

}
