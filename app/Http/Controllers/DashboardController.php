<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Avurnav;
use App\Models\Pollution;
use App\Models\Sitrep;
use App\Models\BilanSar;
use App\Models\Region;
use App\Models\Peche;

class DashboardController extends Controller
{
    /**
     * Contrôleur du tableau de bord.
     */
    public function index()
    {
        // Comptage global des différents éléments
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

        // Comptage des bilans SAR par région
        $regionsData = BilanSar::selectRaw('region_id, COUNT(*) as count')
            ->groupBy('region_id')
            ->with('region')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->region->nom ?? 'Inconnu',
                    'count' => $item->count
                ];
            });

         // Récupération des totaux pour les statistiques SAR
        $bilanStats = BilanSar::selectRaw('
        SUM(pob) as pob_total, 
        SUM(survivants) as survivants_total, 
        SUM(blesses) as blesses_total, 
        SUM(morts) as morts_total, 
        SUM(disparus) as disparus_total, 
        SUM(evasan) as evasan_total
    ')->first();

    // 🔹 Comptage des entrées pour chaque zone (1 à 9)
    $zoneCounts = [];
    for ($i = 1; $i <= 9; $i++) {
        $modelClass = "App\\Models\\zone_$i";
        if (class_exists($modelClass)) {
            $zoneCounts["Zone $i"] = $modelClass::count();
        }
    }

     // 🔹 **Ajout du comptage des flags des navires de pêche**
     $flagData = Peche::selectRaw('flag, COUNT(*) as count')
     ->groupBy('flag')
     ->get()
     ->map(function ($item) {
         return [
             'name' => $item->flag,
             'count' => $item->count
         ];
     });

    return view('dashboard', compact(
        'articleCount', 'avurnavCount', 'pollutionCount', 'sitrepCount', 'bilanSarCount', 
        'typesData', 'causesData', 'regionsData', 'bilanStats', 'zoneCounts', 'flagData'
    ));
    }
    
}