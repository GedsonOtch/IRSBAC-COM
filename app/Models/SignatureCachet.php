<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignatureCachet extends Model
{
    //

      protected $fillable = [
        'fonction',
        'type',
        'nom_responsable',
        'image_path'
    ];

    public static function get(string $fonction, string $type): ?self
    {
      return static::where('fonction', $fonction)->where('type', $type)->first();
    }
}
