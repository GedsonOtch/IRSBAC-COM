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

    protected $casts = [
        'date_deliberation' => 'date',
        'date_document' => 'date'
    ];

      public function getNumeroFormateAttribute() : string 
    {
return str_pad($this->numero_attestation, 4, '0', STR_PAD_LEFT);
    }
    public function etudiant()
    {
        return $this->belongsTo(
            Etudiant::class
        );
    }
}