<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerangkatDesa extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'nik', 'nik');
    }
}
