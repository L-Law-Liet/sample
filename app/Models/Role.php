<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 1;
    const ROLE_TECHNICIAN = 2;
    const ROLE_CLIENT = 3;
}
