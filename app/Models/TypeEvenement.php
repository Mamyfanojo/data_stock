<?php

// Modèle TypeEvenement
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEvenement extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function bilans()
    {
        return $this->hasMany(BilanSar::class, 'type_d_evenement_id');
    }
}
