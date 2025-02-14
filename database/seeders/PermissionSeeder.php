<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_permission = public_path('json/permissions.json');
        $json_permission = file_get_contents($file_permission);
        $data_permission = json_decode($json_permission, true);

        echo "Memulai proses seeder data Permission...\n";
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('permissions')->insert($data_permission);
        echo "Done seeder data Permission...\n";
    }
}