<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ecue;
class Ue extends Model{


        protected $fillable = [
        'code',
        'nom',
        'semestre',
        'credit',
        'niveau'
    ];

    public function ecues()
    {
        return $this->hasMany(Ecue::class);
    }

public function filieres()
{
    return $this->belongsToMany(
        Filiere::class,
        'filiere_ue',
       
    );
}
}


