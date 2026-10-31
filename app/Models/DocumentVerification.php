<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVerification extends Model
{
    protected $fillable = [
        'verification_token',
        'document_type',
        'document_id',
        'etudiant_id',
        'qr_code_path',
        'is_valid',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'is_valid' => 'boolean',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}