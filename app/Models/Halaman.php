<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    use HasFactory;
    protected $table = 'artikels';
    protected $guarded = ['id'];
    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id', 'id');
    // }
    // public function author()
    // {
    //     return $this->belongsTo(User::class, 'iduser');
    // }
}
