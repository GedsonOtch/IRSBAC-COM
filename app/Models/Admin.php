<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
         'is_active',
    'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
    'last_login_at' => 'datetime',
];
}