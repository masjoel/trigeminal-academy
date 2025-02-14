<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_categories = public_path('json/categories.json');
        $json_categories = file_get_contents($file_categories);
        $data_categories = json_decode($json_categories, true);

        echo "Memulai proses seeder data Category...\n";
        DB::table('categories')->insert($data_categories);
        echo "Done seeder data Category...\n";
    }
}
