<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'kategori'
            ]
        ];
    }
    public static function tipe($var = null)
    {
        return Category::where('tipe', $var)->get();
    }
    public function halaman()
    {
        // return $this->hasMany(Post::class, 'FIND_IN_SET(idartikel, xsite_artikel.idkategori)');
        return $this->hasMany(Artikel::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
