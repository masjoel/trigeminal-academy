<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// $adminRole = Role::create(['name' => 'admin']);
// $userRole = Role::create(['name' => 'user']);
// $kasirRole = Role::create(['name' => 'kasir']);
// $operatorRole = Role::create(['name' => 'operator']);
// $keuanganRole = Role::create(['name' => 'keuangan']);

class RoleManagement extends Model
{
    use HasFactory, HasRoles;
    protected $table = 'roles';
    protected $guarded = ['id'];
}
