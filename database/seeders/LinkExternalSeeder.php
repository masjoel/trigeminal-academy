<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LinkExternal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LinkExternalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userID = User::where('role', 'admin')->first()->id;
        LinkExternal::firstOrCreate(
            ['keterangan' => 'Instagram'],
            [
                'user_id' => $userID,
                'tipe' => 'medsos',
                'icon' => 'fab fa-instagram',
                'url_ext' => '',
            ]
        );
        LinkExternal::firstOrCreate(
            ['keterangan' => 'Facebook'],
            [
                'user_id' => $userID,
                'tipe' => 'medsos',
                'icon' => 'fab fa-facebook',
                'url_ext' => '',
            ]
        );
        LinkExternal::firstOrCreate(
            ['keterangan' => 'Twitter'],
            [
                'user_id' => $userID,
                'tipe' => 'medsos',
                'icon' => 'fab fa-twitter',
                'url_ext' => '',
            ]
        );
        LinkExternal::firstOrCreate(
            ['keterangan' => 'Youtube'],
            [
                'user_id' => $userID,
                'tipe' => 'medsos',
                'icon' => 'fab fa-youtube',
                'url_ext' => '',
            ]
        );
        LinkExternal::firstOrCreate(
            ['keterangan' => 'Tiktok'],
            [
                'user_id' => $userID,
                'tipe' => 'medsos',
                'icon' => 'fab fa-tiktok',
                'url_ext' => '',
            ]
        );
        LinkExternal::firstOrCreate(
            ['keterangan' => 'Website'],
            [
                'user_id' => $userID,
                'tipe' => 'external',
                'icon' => 'fa fa-link',
                'url_ext' => '',
            ]
        );
    }
}
