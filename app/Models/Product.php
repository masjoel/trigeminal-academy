<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    public function productContent()
    {
        return $this->hasMany(ProductContent::class, 'product_id');
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
    public function customers(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,   // Model tujuan (Customers)
            Order::class,      // Model perantara kedua (Orders)
            'id',              // Primary key di tabel Orders
            'id',              // Primary key di tabel Customers
            'id',              // Primary key di tabel Products
            'customer_id'          // Foreign key di tabel Orders yang merujuk ke Customers
        );
        // ->distinct(); // Hindari duplikasi jika customer beli lebih dari satu kali
    }
}
