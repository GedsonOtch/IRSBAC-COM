<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Releve extends Model
{
    protected $fillable = [

        'etudiant_id',

        'annee_academique_id',

        'semestre',

        'numero',

        'pdf_path',

        'moyenne',

        'credits_valides',

        'decision',


    ];

    protected $casts = [

        

        'moyenne' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function etudiant()
    {
        return $this->belongsTo(
            Etudiant::class
        );
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(
            AnneeAcademique::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors utiles
    |--------------------------------------------------------------------------
    */

    }
