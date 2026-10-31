<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infoirsbac extends Model
{
    //
     
        protected $fillable = [
        'nom_etablissement',
        'sigle',
        'arrete_autorisation',
        'adresse',
        'telephone',
        'email',
        'site_web',
        'directeur',
        'directeur_etudes'
    ];
}
