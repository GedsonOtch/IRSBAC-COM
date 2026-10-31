<?php

namespace App\Models;
use App\Models\Filiere;
;
use App\Models\Attestation;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'filiere_id',
        'annee_etude',
        'sexe',
        'telephone',
        'password',
        'est_en_regle',
        'photo',
        'annee_entree_id',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'est_en_regle' => 'boolean',
    ];

        public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
    public function attestation()
{
    return $this->hasOne(
        Attestation::class
    );
}


public function getPhotoUrlAttribute()
{
    return $this->photo
        ? asset('storage/' . $this->photo)
        : null;
}

public function getInitialesAttribute()
{
    return strtoupper(
        substr($this->nom ?? '', 0, 1) .
        substr($this->prenom ?? '', 0, 1)
    );
}

public function notes()
{
    return $this->hasMany(
        Note::class
    );
}

public function releves()
{
    return $this->hasMany(
        Releve::class
    );
}

public function releveS6(){

return $this->hasOne(Releve::class)->where('semestre', 6);
}
public function anneeEntree()
{
    return $this->belongsTo(
        AnneeAcademique::class,
        'annee_entree_id'
    );
}

}