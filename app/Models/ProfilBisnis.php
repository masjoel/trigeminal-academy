<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilBisnis extends Model
{
    use HasFactory;
    protected $table = 'perusahaan';
    protected $guarded = ['id'];
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
