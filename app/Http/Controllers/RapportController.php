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

class RapportController extends Controller
{
    /**
     * Affiche le rapport avec les filtres appliqués.
     */
    public function index(Request $request)
    {
        // Comptages globaux (non filtrés, à adapter si nécessaire)
        $articleCount   = Article::count();
        $avurnavCount   = Avurnav::count();
        $pollutionCount = Pollution::count();
        $sitrepCount    = Sitrep::count();
        $bilanSarCount  = BilanSar::count();

        // Récupération des paramètres de filtre
        $dateFilter   = $request->input('filter_date');         // Format : YYYY-MM-DD
        $yearQuarter  = $request->input('filter_year_quarter');   // Année pour le trimestre
        $quarter      = $request->input('filter_quarter');        // 1, 2, 3 ou 4
        $yearMonth    = $request->input('filter_year_month');     // Année pour le mois
        $month        = $request->input('filter_month');          // Mois (1 à 12)

        // Préparation des dates de début et de fin pour le filtre par trimestre
        if ($yearQuarter && $quarter) {
            switch ($quarter) {
                case 1:
                    $start = "$yearQuarter-01-01";
                    $end   = "$yearQuarter-03-31";
                    break;
                case 2:
                    $start = "$yearQuarter-04-01";
                    $end   = "$yearQuarter-06-30";
                    break;
                case 3:
                    $start = "$yearQuarter-07-01";
                    $end   = "$yearQuarter-09-30";
                    break;
                case 4:
                    $start = "$yearQuarter-10-01";
                    $end   = "$yearQuarter-12-31";
                    break;
                default:
                    $start = null;
                    $end   = null;
                    break;
            }
        }

        /*
         * Pour BilanSar :
         * - Si le champ "date" est renseigné, on filtre sur ce champ.
         * - Sinon, on filtre sur "created_at".
         * L'opération est réalisée via COALESCE.
         */
        $bilanSarQuery = BilanSar::query();
        if ($dateFilter) {
            $bilanSarQuery->whereRaw("DATE(COALESCE(`date`, created_at)) = ?", [$dateFilter]);
        } elseif ($yearQuarter && $quarter && isset($start, $end)) {
            $bilanSarQuery->whereRaw("DATE(COALESCE(`date`, created_at)) BETWEEN ? AND ?", [$start, $end]);
        } elseif ($yearMonth && $month) {
            $bilanSarQuery->whereRaw("YEAR(COALESCE(`date`, created_at)) = ? AND MONTH(COALESCE(`date`, created_at)) = ?", [$yearMonth, $month]);
        }

        // Récupération des données pour les graphiques à partir de la requête filtrée

        // Types d'événements
        $typesData = (clone $bilanSarQuery)
            ->selectRaw('type_d_evenement_id, COUNT(*) as count')
            ->groupBy('type_d_evenement_id')
            ->with('typeEvenement')
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->typeEvenement->nom ?? 'Inconnu',
                    'count' => $item->count,
                ];
            });

        // Causes d'événements
        $causesData = (clone $bilanSarQuery)
            ->selectRaw('cause_de_l_evenement_id, COUNT(*) as count')
            ->groupBy('cause_de_l_evenement_id')
            ->with('causeEvenement')
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->causeEvenement->nom ?? 'Inconnu',
                    'count' => $item->count,
                ];
            });

        // Bilans SAR par région
        $regionsData = (clone $bilanSarQuery)
            ->selectRaw('region_id, COUNT(*) as count')
            ->groupBy('region_id')
            ->with('region')
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->region->nom ?? 'Inconnu',
                    'count' => $item->count,
                ];
            });

        // Statistiques SAR
        $bilanStats = (clone $bilanSarQuery)
            ->selectRaw('
                SUM(pob) as pob_total, 
                SUM(survivants) as survivants_total, 
                SUM(blesses) as blesses_total, 
                SUM(morts) as morts_total, 
                SUM(disparus) as disparus_total, 
                SUM(evasan) as evasan_total
            ')
            ->first();

        /*
         * Pour Peche et les zones, on applique le filtre sur le champ "date" (format ISO).
         */
        $zoneCounts = [];
        for ($i = 1; $i <= 9; $i++) {
            $modelClass = "App\\Models\\zone_$i";
            if (class_exists($modelClass)) {
                $query = $modelClass::query();
                if ($dateFilter) {
                    $query->whereDate('time_of_fix', $dateFilter);
                } elseif ($yearQuarter && $quarter && isset($start, $end)) {
                    $query->whereBetween('time_of_fix', [$start, $end]);
                } elseif ($yearMonth && $month) {
                    $query->whereYear('time_of_fix', $yearMonth)
                          ->whereMonth('time_of_fix', $month);
                }
                $zoneCounts["Zone $i"] = $query->count();
            }
        }

        $flagQuery = Peche::query();
        if ($dateFilter) {
            $flagQuery->whereDate('time_of_fix', $dateFilter);
        } elseif ($yearQuarter && $quarter && isset($start, $end)) {
            $flagQuery->whereBetween('time_of_fix', [$start, $end]);
        } elseif ($yearMonth && $month) {
            $flagQuery->whereYear('time_of_fix', $yearMonth)
                      ->whereMonth('time_of_fix', $month);
        }
        $flagData = $flagQuery
            ->selectRaw('flag, COUNT(*) as count')
            ->groupBy('flag')
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->flag,
                    'count' => $item->count,
                ];
            });

        // Construction du texte récapitulatif du filtre
        if ($dateFilter) {
            $filterResult = "Données du " . $dateFilter;
        } elseif ($yearQuarter && $quarter) {
            $qText = ($quarter == 1) ? "1er trimestre" : $quarter . "ème trimestre";
            $filterResult = "Données de l'année $yearQuarter - $qText";
        } elseif ($yearMonth && $month) {
            $months = [
                1 => "janvier", 2 => "février", 3 => "mars", 4 => "avril",
                5 => "mai", 6 => "juin", 7 => "juillet", 8 => "août",
                9 => "septembre", 10 => "octobre", 11 => "novembre", 12 => "décembre"
            ];
            $monthName = $months[(int)$month] ?? $month;
            $filterResult = "Données de l'année $yearMonth - mois de $monthName";
        } else {
            $filterResult = "Toutes les données";
        }

        return view('rapport', compact(
            'articleCount',
            'avurnavCount',
            'pollutionCount',
            'sitrepCount',
            'bilanSarCount',
            'typesData',
            'causesData',
            'regionsData',
            'bilanStats',
            'zoneCounts',
            'flagData',
            'filterResult'
        ));
    }
}
