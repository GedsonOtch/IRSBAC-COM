<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecuritySetting extends Model
{
    //

    protected $fillable = [
    'session_timeout',
    'maintenance_mode',
    'audit_log'
];
}
