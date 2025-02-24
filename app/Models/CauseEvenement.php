<?php
// Modèle CauseEvenement
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauseEvenement extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function bilans()
    {
        return $this->hasMany(BilanSar::class, 'cause_de_l_evenement_id');
    }
}
