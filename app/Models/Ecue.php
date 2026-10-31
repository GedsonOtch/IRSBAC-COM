<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Ue;


class Ecue extends Model
{
    //

        protected $fillable = [
        'code',
        'nom',
        'coefficient',
        'ue_id'
    ];

    public function ue()
    {
        return $this->belongsTo(Ue::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
