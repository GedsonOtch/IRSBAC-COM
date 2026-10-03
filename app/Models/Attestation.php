<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Etudiant;
class Attestation extends Model
{
    protected $fillable = [

        'etudiant_id',
        'numero_attestation',
        'pdf_path',
        'date_deliberation',  
        'date_document',
        'annee_academique'
    ];

    public function etudiant()
    {
        return $this->belongsTo(
            Etudiant::class
        );
    }
}