<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function instruktur()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderitems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
