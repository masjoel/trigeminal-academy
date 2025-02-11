<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function perangkatDesa()
    {
        return $this->belongsTo(PerangkatDesa::class, 'user_id');
    }
}

