<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model
{
    //

       protected $table = 'annees_academiques';
     protected $fillable = [
        'libelle'
    ];

    public function releves()
{
    return $this->hasMany(
        Releve::class
    );
}
}
