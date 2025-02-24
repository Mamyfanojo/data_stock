<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Avurnav;
use App\Models\Pollution;
use App\Models\Sitrep;
use App\Models\BilanSar;

class DashboardController extends Controller
{

    public function index()
    {
        $articleCount = Article::count();
        $avurnavCount = Avurnav::count();
        $pollutionCount = Pollution::count();
        $sitrepCount = Sitrep::count();
        $bilanSarCount = BilanSar::count();
    
        // Comptage des types d'événements
        $typesData = BilanSar::selectRaw('type_d_evenement_id, COUNT(*) as count')
            ->groupBy('type_d_evenement_id')
            ->with('typeEvenement')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->typeEvenement->nom ?? 'Inconnu',
                    'count' => $item->count
                ];
            });
    
        // Comptage des causes d'événements
        $causesData = BilanSar::selectRaw('cause_de_l_evenement_id, COUNT(*) as count')
            ->groupBy('cause_de_l_evenement_id')
            ->with('causeEvenement')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->causeEvenement->nom ?? 'Inconnu',
                    'count' => $item->count
                ];
            });
    
        return view('dashboard', compact(
            'articleCount', 'avurnavCount', 'pollutionCount', 'sitrepCount', 'bilanSarCount', 
            'typesData', 'causesData'
        ));
    }
    
}