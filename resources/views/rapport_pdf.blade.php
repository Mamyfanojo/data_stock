<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif; /* Pour supporter les caractères accentués */
            font-size: 14px;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-info {
            background-color: #f2f2f2;
            padding: 10px;
            margin-bottom: 30px;
            border-radius: 4px;
        }
        .chart-section {
            margin-bottom: 40px;
            text-align: center;
            page-break-inside: avoid;
        }
        .chart-section h2 {
            margin-bottom: 10px;
        }
        .chart-image {
            max-width: 600px;
            margin: 0 auto;
        }
        .chart-image img {
            width: 100%;
        }
        .chart-desc {
            margin-top: 10px;
            text-align: left;
            width: 80%;
            margin: 10px auto 0 auto;
        }
        .chart-desc ul {
            list-style: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>

    <h1>Rapport PDF - Résultats filtrés</h1>

    @if(isset($filterResult))
    <div class="filter-info">
        <strong>Filtre appliqué :</strong> {{ $filterResult }}
    </div>
    @endif

    <!-- Section 1 : Répartition des Types d'Événements -->
    @if(isset($typesChartUrl) && isset($typesData))
    <div class="chart-section">
        <h2>Répartition des Types d'Événements</h2>
        <div class="chart-image">
            <img src="{{ $typesChartUrl }}" alt="Graphique Types">
        </div>
        <div class="chart-desc">
            <p>Liste des types d'événements et leurs nombres :</p>
            <ul>
                @foreach($typesData as $type)
                    <li>{{ $type['name'] }} : {{ $type['count'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Section 2 : Répartition des Causes d'Événements -->
    @if(isset($causesChartUrl) && isset($causesData))
    <div class="chart-section">
        <h2>Répartition des Causes d'Événements</h2>
        <div class="chart-image">
            <img src="{{ $causesChartUrl }}" alt="Graphique Causes">
        </div>
        <div class="chart-desc">
            <p>Liste des causes d'événements et leurs nombres :</p>
            <ul>
                @foreach($causesData as $cause)
                    <li>{{ $cause['name'] }} : {{ $cause['count'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Section 3 : Répartition des Bilans SAR par Région -->
    @if(isset($regionsChartUrl) && isset($regionsData))
    <div class="chart-section">
        <h2>Répartition des Bilans SAR par Région</h2>
        <div class="chart-image">
            <img src="{{ $regionsChartUrl }}" alt="Graphique Régions">
        </div>
        <div class="chart-desc">
            <p>Liste des régions et leur nombre de bilans SAR :</p>
            <ul>
                @foreach($regionsData as $region)
                    <li>{{ $region['name'] }} : {{ $region['count'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Section 4 : Statistiques des Bilans SAR -->
    @if(isset($bilanStats))
    <div class="chart-section">
        <h2>Statistiques des Bilans SAR</h2>
        <div class="chart-image">
            <img src="{{ $bilanChartUrl }}" alt="Graphique Régions">
        </div>
        <div class="chart-desc">
            <ul>
                <li>POB : {{ $bilanStats->pob_total ?? 0 }}</li>
                <li>Survivants : {{ $bilanStats->survivants_total ?? 0 }}</li>
                <li>Blessés : {{ $bilanStats->blesses_total ?? 0 }}</li>
                <li>Morts : {{ $bilanStats->morts_total ?? 0 }}</li>
                <li>Disparus : {{ $bilanStats->disparus_total ?? 0 }}</li>
                <li>Evasan : {{ $bilanStats->evasan_total ?? 0 }}</li>
            </ul>
        </div>
    </div>
    @endif

    <!-- Section 5 : Nombre d'entrées par zone -->
    @if(isset($zoneChartUrl) && isset($zoneCounts))
    <div class="chart-section">
        <h2>Nombre d'entrées par zone</h2>
        <div class="chart-image">
            <img src="{{ $zoneChartUrl }}" alt="Graphique Zones">
        </div>
        <div class="chart-desc">
            <p>Liste des zones et nombre d'entrées :</p>
            <ul>
                @foreach($zoneCounts as $zoneName => $count)
                    <li>{{ $zoneName }} : {{ $count }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Section 6 : Répartition des navires par Flag -->
    @if(isset($flagChartUrl) && isset($flagData))
    <div class="chart-section">
        <h2>Répartition des navires par Flag</h2>
        <div class="chart-image">
            <img src="{{ $flagChartUrl }}" alt="Graphique Flags">
        </div>
        <div class="chart-desc">
            <p>Liste des flags et nombre de navires :</p>
            <ul>
                @foreach($flagData as $flag)
                    <li>{{ $flag['name'] }} : {{ $flag['count'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

</body>
</html>
