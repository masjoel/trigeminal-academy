<?php

namespace Database\Seeders;

use App\Models\Desa;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Category;
use App\Models\Instructor;
use App\Models\ProfilBisnis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ProfilBisnis::create([
            'nama_client' => 'Trigeminal Academy',
            'nama_app' => 'Trigeminal Academy',
            'versi_app' => '1.0',
            'desc_app' => 'Aplikasi Trigeminal Academy-Website',
            'alamat_client' => 'Jl. Raya No.1',
            'signature' => 'Trigeminal Academy',
            'email' => 'admin@email.com',
            'logo' => 'image/logo-lkp2mpd.jpg',
            'image_icon' => 'image/icon-lkp2mpd.png',
            'mcad' => null,
            'init' => null,
            'bank' => null,
            'footnot' => null,
            'jdigit' => 0,
            'jdelay' => 0,
        ]);
        Desa::create([
            'nama_client' => 'Trigeminal Academy',
            'kodedesa' => '00000000',
            'provinsi' => 'Jawa Tengah',
            'kabupaten' => 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'alamat_client' => 'Jl. Raya No.1',
            'kades' => 'Ketua',
            'sekretaris' => 'Sekretaris',
            'bendahara' => 'Bendahara',
            'logo' => 'image/icon-lkp2mpd.png',
            'photo' => 'image/icon-foto.png',
            'image_icon' => 'image/icon-lkp2mpd.png',
            'apikey' => Uuid::uuid1()->getHex(),
        ]);
        Instructor::create([
            'user_id' => '1',
            'nama' => 'Zhakiah',
            'slug' => 'zhakiah',
            'alamat' => 'Semarang',
            'telpon' => '08123456789',
            'email' => 'admin@email.com',
            'keterangan' => 'Instruktur Trigeminal Academy',
            'approval' => 'approved',
            'kategori' => 'umum',
        ]);
        $this->call([
            UserSeeder::class,
            RolesSeeder::class,
            CategorySeeder::class,
            PermissionSeeder::class,
            RolesAndPermissionsSeeder::class,
            RolesAndPermissionsSeeder::class,
            LinkExternalSeeder::class,
            FromJsonSeeder::class,
        ]);
    }
}
