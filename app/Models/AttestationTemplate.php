<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttestationTemplate extends Model
{
    //
       protected $fillable = [
        'nom',
        'pdf_path',
        'actif'
    ];
}
