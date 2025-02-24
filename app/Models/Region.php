<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    // Une région peut avoir plusieurs Bilans SAR
    public function bilans()
    {
        return $this->hasMany(BilanSar::class, 'region_id');
    }
}