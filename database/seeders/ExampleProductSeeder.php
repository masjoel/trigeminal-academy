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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('products')->truncate();
        DB::table('product_contents')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('instructors')->truncate();
        DB::table('students')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Faker::create('id_ID');

        // Seeding product_categories
        for ($i = 0; $i < 5; $i++) {
            DB::table('product_categories')->insert([
                'user_id' => null,
                'name' => $faker->word,
                'description' => $faker->sentence,
                'thumbnail' => $faker->imageUrl(640, 480, 'business'),
                'warna' => $faker->hexColor,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeding instructors
        for ($i = 0; $i < 5; $i++) {
            DB::table('instructors')->insert([
                'user_id' => null,
                'nama' => $faker->name,
                'slug' => $faker->slug,
                'alamat' => $faker->address,
                'telpon' => $faker->phoneNumber,
                'email' => $faker->email,
                'photo' => $faker->imageUrl(640, 480, 'people'),
                'keterangan' => $faker->sentence,
                'ktp' => $faker->numerify('##############'),
                'npwp' => $faker->numerify('##.###.###.#-###.###'),
                'bank' => $faker->company,
                'rekening' => $faker->bankAccountNumber,
                'approval' => $faker->randomElement(['pending', 'approved']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeding students
        for ($i = 0; $i < 10; $i++) {
            DB::table('students')->insert([
                'user_id' => null,
                'nama' => $faker->name,
                'slug' => $faker->slug,
                'alamat' => $faker->address,
                'telpon' => $faker->phoneNumber,
                'email' => $faker->email,
                'photo' => $faker->imageUrl(640, 480, 'people'),
                'keterangan' => $faker->sentence,
                'ktp' => $faker->numerify('##############'),
                'npwp' => $faker->numerify('##.###.###.#-###.###'),
                'bank' => $faker->company,
                'rekening' => $faker->bankAccountNumber,
                'approval' => $faker->randomElement(['pending', 'approved']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeding products
        for ($i = 0; $i < 20; $i++) {
            $productId = DB::table('products')->insertGetId([
                'user_id' => null,
                'category_id' => rand(1, 5),
                'instructor_id' => rand(1, 5),
                'instructor' => $faker->name,
                'name' => $faker->word,
                'slug' => $faker->slug,
                'size' => $faker->randomFloat(2, 1, 100),
                'excerpt' => $faker->sentence,
                'description' => $faker->paragraph,
                'budget' => $faker->randomFloat(2, 10000, 500000),
                'price' => $faker->randomFloat(2, 10000, 1000000),
                'discount' => $faker->randomFloat(2, 0, 50),
                'stock' => $faker->numberBetween(1, 100),
                'stock_min' => $faker->numberBetween(1, 10),
                'in_stock' => $faker->boolean,
                'publish' => $faker->boolean,
                'level' => $faker->randomElement(['pemula', 'menengah', 'mahir']),
                'image_url' => $faker->imageUrl(640, 480, 'products'),
                'storage_type' => $faker->randomElement(['local', 'cloud']),
                'video_url' => $faker->url,
                'video_duration' => $faker->numberBetween(60, 3600),
                'download_url' => $faker->url,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Seeding product_contents
            for ($j = 0; $j < rand(1, 10); $j++) {
                DB::table('product_contents')->insert([
                    'product_id' => $productId,
                    'parent' => null,
                    'title' => $faker->sentence,
                    'storage_type' => $faker->randomElement(['youtube', 'local']),
                    'video_url' => $faker->url,
                    'duration' => $faker->randomFloat(2, 5, 120),
                    'description' => $faker->sentence,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
