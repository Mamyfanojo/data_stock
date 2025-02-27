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
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf; // Alias pour Barryvdh\DomPDF\Facade

class RapportController extends Controller
{
    /**
     * Affiche le rapport avec les filtres appliqués (version HTML).
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
        $yearQuarter  = $request->input('filter_year_quarter'); // Année pour le trimestre
        $quarter      = $request->input('filter_quarter');      // 1, 2, 3 ou 4
        $yearMonth    = $request->input('filter_year_month');   // Année pour le mois
        $month        = $request->input('filter_month');        // Mois (1 à 12)

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
         * L'opération est réalisée via COALESCE(`date`, created_at).
         */
        $bilanSarQuery = BilanSar::query();
        if ($dateFilter) {
            $bilanSarQuery->whereRaw("DATE(COALESCE(`date`, created_at)) = ?", [$dateFilter]);
        } elseif ($yearQuarter && $quarter && isset($start, $end)) {
            $bilanSarQuery->whereRaw("DATE(COALESCE(`date`, created_at)) BETWEEN ? AND ?", [$start, $end]);
        } elseif ($yearMonth && $month) {
            $bilanSarQuery->whereRaw("YEAR(COALESCE(`date`, created_at)) = ? AND MONTH(COALESCE(`date`, created_at)) = ?", [$yearMonth, $month]);
        }

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
         * Pour Peche et les zones, on applique le filtre sur "time_of_fix" (format ISO).
         */
        // Zones
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

        // Flags (navires de pêche)
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

        // Retourne la vue HTML
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

    /**
     * Exporte en PDF les mêmes données filtrées.
     */
    public function exportPdf(Request $request)
    {
        // Pour laisser plus de temps si besoin (optionnel)
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        // Récupération des filtres
        $dateFilter   = $request->input('filter_date');
        $yearQuarter  = $request->input('filter_year_quarter');
        $quarter      = $request->input('filter_quarter');
        $yearMonth    = $request->input('filter_year_month');
        $month        = $request->input('filter_month');

        // Détermination de la plage de dates pour le trimestre
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
            }
        }

        // Construction de la requête filtrée pour BilanSar
        $bilanSarQuery = BilanSar::query();
        if ($dateFilter) {
            $bilanSarQuery->whereRaw("DATE(COALESCE(`date`, created_at)) = ?", [$dateFilter]);
        } elseif ($yearQuarter && $quarter && isset($start, $end)) {
            $bilanSarQuery->whereRaw("DATE(COALESCE(`date`, created_at)) BETWEEN ? AND ?", [$start, $end]);
        } elseif ($yearMonth && $month) {
            $bilanSarQuery->whereRaw("YEAR(COALESCE(`date`, created_at)) = ? AND MONTH(COALESCE(`date`, created_at)) = ?", [$yearMonth, $month]);
        }

        // Construction d'une clé de cache basée sur l'URL complète des filtres
        $cacheKey = 'rapport_pdf_data_' . md5($request->fullUrl());

        // Mettre en cache les données pour 10 minutes
        $data = Cache::remember($cacheKey, now()->addMinutes(10), function() use ($bilanSarQuery, $request, $dateFilter, $yearQuarter, $quarter, $yearMonth, $month, $start, $end) {

            // 1. Types d'événements
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
            $typesLabels = $typesData->pluck('name')->toArray();
            $typesCounts = $typesData->pluck('count')->toArray();
            $typesChartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $typesLabels,
                    'datasets' => [[
                        'label' => "Nombre d'événements",
                        'data'  => $typesCounts,
                        'backgroundColor' => '#4CAF50',
                    ]]
                ],
                'options' => [
                    'scales' => [
                        'y' => [
                            'type' => 'linear',
                            'min' => 0,
                            'ticks' => [
                                'beginAtZero' => true
                            ]
                        ]
                    ]
                ]
            ];
            // Réduction de la taille de l'image pour alléger le PDF
            $typesChartUrl = 'https://quickchart.io/chart?width=600&height=300&version=3&c=' . urlencode(json_encode($typesChartConfig));

            // 2. Causes d'événements
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
            $causesLabels = $causesData->pluck('name')->toArray();
            $causesCounts = $causesData->pluck('count')->toArray();
            $causesChartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $causesLabels,
                    'datasets' => [[
                        'label' => "Nombre d'événements (Causes)",
                        'data'  => $causesCounts,
                        'backgroundColor' => '#FF9800',
                    ]]
                ],
                'options' => [
                    'responsive' => true,
                    'scales' => [
                        'y' => [
                            'type' => 'linear',
                            'min' => 0,
                            'ticks' => [
                                'beginAtZero' => true,
                                'stepSize' => 1
                            ]
                        ]
                    ]
                ]
            ];
            $causesChartUrl = 'https://quickchart.io/chart?width=600&height=300&version=3&c=' . urlencode(json_encode($causesChartConfig));

            // 3. Répartition des Bilans SAR par Région
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
            $regionsLabels = $regionsData->pluck('name')->toArray();
            $regionsCounts = $regionsData->pluck('count')->toArray();
            $regionsChartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $regionsLabels,
                    'datasets' => [[
                        'label' => "Nombre de bilans SAR (Régions)",
                        'data'  => $regionsCounts,
                        'backgroundColor' => '#FFC107'
                    ]]
                ],
                'options' => [
                    'scales' => [
                        'y' => [
                            'beginAtZero' => true,
                            'min' => 0
                        ]
                    ]
                ]
            ];
            $regionsChartUrl = 'https://quickchart.io/chart?width=600&height=300&version=3&c=' . urlencode(json_encode($regionsChartConfig));

            // 4. Statistiques des Bilans SAR
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
            $bilanLabels = ["POB", "Survivants", "Blessés", "Morts", "Disparus", "Evasan"];
            $bilanCounts = [
                $bilanStats->pob_total ?? 0,
                $bilanStats->survivants_total ?? 0,
                $bilanStats->blesses_total ?? 0,
                $bilanStats->morts_total ?? 0,
                $bilanStats->disparus_total ?? 0,
                $bilanStats->evasan_total ?? 0,
            ];
            $bilanChartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $bilanLabels,
                    'datasets' => [[
                        'label' => 'Statistiques des Bilans SAR',
                        'data'  => $bilanCounts,
                        'backgroundColor' => ['#4CAF50', '#2196F3', '#FF9800', '#F44336', '#9C27B0', '#795548']
                    ]]
                ],
                'options' => [
                    'scales' => [
                        'y' => [
                            'beginAtZero' => true,
                            'min' => 0
                        ]
                    ]
                ]
            ];
            $bilanChartUrl = 'https://quickchart.io/chart?width=600&height=300&version=3&c=' . urlencode(json_encode($bilanChartConfig));

            // 5. Nombre d'entrées par Zone
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
            $zoneLabels = array_keys($zoneCounts);
            $zoneValues = array_values($zoneCounts);
            $zoneChartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $zoneLabels,
                    'datasets' => [[
                        'label' => "Nombre d'entrées par zone",
                        'data'  => $zoneValues,
                        'backgroundColor' => '#17a2b8'
                    ]]
                ],
                'options' => [
                    'scales' => [
                        'y' => [
                            'beginAtZero' => true,
                            'min' => 0
                        ]
                    ]
                ]
            ];
            $zoneChartUrl = 'https://quickchart.io/chart?width=600&height=300&version=3&c=' . urlencode(json_encode($zoneChartConfig));

            // 6. Flags (navires de pêche)
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
            $flagLabels = $flagData->pluck('name')->toArray();
            $flagCounts = $flagData->pluck('count')->toArray();
            $flagChartConfig = [
                'type' => 'doughnut',
                'data' => [
                    'labels' => $flagLabels,
                    'datasets' => [[
                        'label' => 'Nombre de navires',
                        'data'  => $flagCounts,
                        'backgroundColor' => ['#FF5733', '#33FF57', '#3357FF', '#F3FF33', '#FF33A8'],
                    ]]
                ]
            ];
            $flagChartUrl = 'https://quickchart.io/chart?width=600&height=300&version=3&c=' . urlencode(json_encode($flagChartConfig));

            // Construction du texte récapitulatif du filtre
            if ($dateFilter) {
                $filterResult = " " . $dateFilter;
            } elseif ($yearQuarter && $quarter) {
                $qText = ($quarter == 1) ? "1er trimestre" : $quarter . "ème trimestre";
                $filterResult = "l'année $yearQuarter - $qText";
            } elseif ($yearMonth && $month) {
                $months = [
                    1 => "janvier", 2 => "février", 3 => "mars", 4 => "avril",
                    5 => "mai", 6 => "juin", 7 => "juillet", 8 => "août",
                    9 => "septembre", 10 => "octobre", 11 => "novembre", 12 => "décembre"
                ];
                $monthName = $months[(int)$month] ?? $month;
                $filterResult = "l'année $yearMonth - mois de $monthName";
            } else {
                $filterResult = "Toutes les données";
            }
    
            return [
                'filterResult'    => $filterResult,
                'typesData'       => $typesData,
                'typesChartUrl'   => $typesChartUrl,
                'causesData'      => $causesData,
                'causesChartUrl'  => $causesChartUrl,
                'regionsData'     => $regionsData,
                'regionsChartUrl' => $regionsChartUrl,
                'bilanStats'      => $bilanStats,
                'bilanChartUrl'   => $bilanChartUrl,
                'zoneCounts'      => $zoneCounts,
                'zoneChartUrl'    => $zoneChartUrl,
                'flagData'        => $flagData,
                'flagChartUrl'    => $flagChartUrl,
            ];
       });
    
       // Génération du PDF en activant les images distantes
       $pdf = PDF::loadView('rapport_pdf', $data)
                 ->setOptions(['isRemoteEnabled' => true]);
    
       return $pdf->download('rapport_'.$data['filterResult'].'.pdf');
    }
     // return view('rapport_pdf',compact('filterResult', 'typesChartUrl','causesChartUrl', 'causesData', 'typesData', 'regionsChartUrl', 'regionsData', 'bilanStats', 'bilanChartUrl', 'zoneChartUrl', 'zoneCounts','flagChartUrl','flagData' ));
}
