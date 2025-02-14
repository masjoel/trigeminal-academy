<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::find(1);
        $userRole = Role::where('name', 'admin')->first();
        $permission = Permission::all();
        $admin->assignRole($userRole);
        $admin->givePermissionTo($permission);

        $user = User::find(2);
        $userRole = Role::where('name', 'user')->first();
        $permission = Permission::where('name', 'not like', '%.%')->where('name', 'not like', '%user%')->where('name', 'not like', '%role%')->where('name', 'not like', '%permission%')->where('name', 'not like', '%backup%')->where('name', 'not like', '%restore%')->get();
        $user->assignRole($userRole);
        $user->givePermissionTo($permission);
        $user = User::find(3);
        $userRole = Role::where('name', 'staf')->first();
        $permission = Permission::where('name', 'not like', '%.%')->where('name', 'not like', '%user%')->where('name', 'not like', '%role%')->where('name', 'not like', '%permission%')->where('name', 'not like', '%backup%')->where('name', 'not like', '%restore%')->get();
        $user->assignRole($userRole);
        $user->givePermissionTo($permission);
        $user = User::find(4);
        $userRole = Role::where('name', 'operator')->first();
        $permission = Permission::where('name', 'not like', '%.%')->where('name', 'not like', '%user%')->where('name', 'not like', '%role%')->where('name', 'not like', '%permission%')->where('name', 'not like', '%backup%')->where('name', 'not like', '%restore%')->get();
        $user->assignRole($userRole);
        $user->givePermissionTo($permission);
    }
}
