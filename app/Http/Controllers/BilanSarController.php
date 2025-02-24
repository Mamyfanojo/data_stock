<?php

namespace App\Http\Controllers;

use App\Models\BilanSar;
use App\Models\Region;
use App\Models\TypeEvenement;
use App\Models\CauseEvenement;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class BilanSarController extends Controller
{
    public function index()
    {
        $bilans = BilanSar::with(['typeEvenement', 'causeEvenement'])->paginate(10);
        return view('surveillance.bilan_sars.index', compact('bilans'));
    }

    public function create()
    {
        $types_evenement = TypeEvenement::all();
        $causes_evenement = CauseEvenement::all();
        $regions = Region::all();
        return view('surveillance.bilan_sars.create', compact('types_evenement', 'causes_evenement', 'regions'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
            'nom_du_navire' => 'nullable|string',
            'pavillon' => 'nullable|string',
            'immatriculation_callsign' => 'nullable|string',
            'armateur_proprietaire' => 'nullable|string',
            'type_du_navire' => 'nullable|string',
            'coque' => 'nullable|string',
            'propulsion' => 'nullable|string',
            'moyen_d_alerte' => 'nullable|string',
            'type_d_evenement_id' => 'nullable|exists:type_evenements,id',
            'cause_de_l_evenement_id' => 'nullable|exists:cause_evenements,id',
            'description_de_l_evenement' => 'nullable|string',
            'lieu_de_l_evenement' => 'nullable|string',
            'region_id' => 'nullable|exists:regions,id', // Modification ici
            'type_d_intervention' => 'nullable|string',
            'description_de_l_intervention' => 'nullable|string',
            'source_de_l_information' => 'nullable|string',
            'pob' => 'nullable|integer',
            'survivants' => 'nullable|integer',
            'blesses' => 'nullable|integer',
            'morts' => 'nullable|integer',
            'disparus' => 'nullable|integer',
            'evasan' => 'nullable|integer',
            'bilan_materiel' => 'nullable|string',
        ]);
    
        BilanSar::create($request->all());
    
        return redirect()->route('bilan_sars.index')->with('success', 'Bilan SAR ajouté avec succès.');
    }
                                                                                                          

    public function destroy(BilanSar $bilanSar)
    {
        $bilanSar->delete();
        return redirect()->route('bilan_sars.index');
    }

}
