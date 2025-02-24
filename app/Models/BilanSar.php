<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BilanSar extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'nom_du_navire', 'pavillon', 'immatriculation_callsign', 'armateur_proprietaire',
        'type_du_navire', 'coque', 'propulsion', 'moyen_d_alerte', 'type_d_evenement_id',
        'description_de_l_evenement', 'cause_de_l_evenement_id', 'lieu_de_l_evenement', 'region',
        'type_d_intervention', 'description_de_l_intervention', 'source_de_l_information',
        'pob', 'survivants', 'blesses', 'morts', 'disparus', 'evasan', 'bilan_materiel'
    ];

    public function typeEvenement()
    {
        return $this->belongsTo(TypeEvenement::class, 'type_d_evenement_id');
    }

    public function causeEvenement()
    {
        return $this->belongsTo(CauseEvenement::class, 'cause_de_l_evenement_id');
    }
}