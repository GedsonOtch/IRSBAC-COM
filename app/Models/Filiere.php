<?php

namespace App\Models;
use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
public function ues()
{
    return $this->belongsToMany(
        Ue::class,
        'filiere_ue',
        
    );
}
}


