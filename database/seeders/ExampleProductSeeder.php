<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Instructor;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\ProductContent;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExampleProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Nonaktifkan foreign key checks
        Schema::disableForeignKeyConstraints();
        // Kosongkan tabel sebelum seeding
        DB::table('product_contents')->truncate();
        DB::table('products')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('instructors')->truncate();


         // Kosongkan tabel
         Product::truncate();
         ProductContent::truncate();
         ProductCategory::truncate();
         Instructor::truncate();

         // Aktifkan kembali foreign key checks
         Schema::enableForeignKeyConstraints();

        // Buat kategori
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $categories[] = ProductCategory::create([
                'user_id' => 1,
                'name' => $faker->word,
                'description' => $faker->sentence,
                'thumbnail' => $faker->imageUrl(200, 200, 'business'),
            ]);
        }

        // Buat instruktur
        $instructors = [];
        for ($i = 0; $i < 5; $i++) {
            $instructors[] = Instructor::create([
                'user_id' => 1,
                'nama' => $faker->name,
                'slug' => Str::slug($faker->name),
                'alamat' => $faker->address,
                'telpon' => $faker->phoneNumber,
                'email' => $faker->email,
                'photo' => $faker->imageUrl(200, 200, 'people'),
                'keterangan' => $faker->sentence,
                'approval' => $faker->randomElement(['pending', 'approved']),
                'kategori' => $faker->randomElement(['muslim', 'umum']),
                'saldo' => $faker->randomFloat(2, 100000, 5000000),
            ]);
        }

        // Buat produk
        for ($i = 0; $i < 20; $i++) {
            $category = $faker->randomElement($categories);
            $instructor = $faker->randomElement($instructors);

            $product = Product::create([
                'user_id' => 1,
                'category_id' => $category->id,
                'instructor_id' => $instructor->id,
                'instructor' => $instructor->nama,
                'name' => $faker->sentence(3),
                'slug' => Str::slug($faker->sentence(3)),
                'size' => $faker->randomFloat(2, 1, 50),
                'description' => $faker->paragraph,
                'budget' => $faker->randomFloat(2, 100000, 5000000),
                'price' => $faker->randomFloat(2, 50000, 2000000),
                'discount' => $faker->randomFloat(2, 0, 50),
                'stock' => $faker->numberBetween(1, 100),
                'stock_min' => $faker->numberBetween(1, 5),
                'in_stock' => true,
                'publish' => true,
                'level' => $faker->randomElement(['pemula', 'menengah', 'mahir']),
                'image_url' => $faker->imageUrl(640, 480, 'business'),
                'storage_type' => 'local',
                'video_url' => 'https://www.youtube.com/watch?v=' . Str::random(10),
                'video_duration' => $faker->numberBetween(60, 300),
                'download_url' => $faker->url,
            ]);

            // Buat konten untuk produk
            for ($j = 0; $j < rand(2, 5); $j++) {
                ProductContent::create([
                    'product_id' => $product->id,
                    'parent' => null,
                    'title' => $faker->sentence,
                    'storage_type' => 'youtube',
                    'video_url' => 'https://www.youtube.com/watch?v=' . Str::random(10),
                    'duration' => $faker->numberBetween(60, 600),
                    'description' => $faker->sentence,
                ]);
            }
        }
    }
}
