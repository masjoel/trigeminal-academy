<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionManagement extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $guarded = ['id'];
}
