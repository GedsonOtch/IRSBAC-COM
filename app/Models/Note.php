<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [

        'etudiant_id',

        'ecue_id',

        'annee_academique_id',

        'note'
    ];

    public function etudiant()
    {
        return $this->belongsTo(
            Etudiant::class
        );
    }

    public function ecue()
    {
        return $this->belongsTo(
            Ecue::class
        );
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(
            AnneeAcademique::class
        );
    }
}
