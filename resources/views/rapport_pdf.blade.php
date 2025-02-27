
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Rapport PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 20px;
        }
        /* ---- SECTION SOMMAIRE ---- */
        .summary-container {
            margin: 40px 0;
            border: 2px solid #1F3A68;
            border-radius: 6px;
            overflow: hidden;
        }
        .summary-header {
            background-color: #1F3A68;
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px;
            font-size: 18px;
            text-align: center;
        }
        .summary-content {
            padding: 20px;
        }
        .summary-content p {
            margin: 5px 0;
            line-height: 1.5;
        }
        .summary-content p strong {
            /* Les titres principaux en gras */
            text-transform: uppercase;
        }
        .ml-5 {
            padding-left: 15%;
        }
        .ml-6 {
            padding-left: 20%;
        }
        /* Conteneur général de la section SAR */
.sar-section {
    margin: 20px 0;
    font-family: "DejaVu Sans", sans-serif; /* Pour PDF + accents */
}

/* Titre principal (ex. "1. EVENEMENTS SAR") */
.sar-section h2 {
    background-color: #0F4C75; /* Couleur de fond bleu foncé */
    color: #fff;              /* Texte blanc */
    padding: 10px;
    margin: 0;
    font-size: 18px;
    text-transform: uppercase;
}

/* Sous-titre (ex. "1.1 TYPES D'INCIDENTS") */
.sar-section h3 {
    background-color: #3282B8; /* Bleu plus clair */
    color: #fff;
    padding: 8px;
    margin-top: 0;  /* Pour coller juste sous h2 */
    margin-left: 20px;
    font-size: 16px;
    text-transform: uppercase;
}

/* Paragraphe descriptif */
.sar-section p {
    margin: 10px 0;
    font-size: 14px;
    line-height: 1.4;
}

/* Conteneur de la section du graphique */
.chart-section {
    margin-top: 20px;
    page-break-inside: avoid; /* Évite la coupure au milieu d'un graphique en PDF */
    text-align: center;
}

/* Titre au-dessus du graphique */
.chart-section h4 {
    color: #9C27B0; /* Par exemple, un mauve/rose */
    margin-bottom: 10px;
    text-transform: uppercase;
    font-size: 16px;
}

/* Conteneur de l'image du graphique */
.chart-image {
    max-width: 600px;   /* Largeur max */
    margin: 0 auto;     /* Centre l'image */
}

/* Style de l'image du graphique */
.chart-image img {
    width: 100%;        /* L'image prend toute la largeur du conteneur */
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    padding: 5px;
}

/* Description/légende sous le graphique */
.chart-desc {
    margin-top: 10px;
    text-align: left;
    width: 80%;         /* Réduit la largeur pour centrer le texte */
    margin: 10px auto 0 auto;
}

.chart-desc p {
    font-weight: bold;
}

.chart-desc ul {
    list-style: disc;
    margin-left: 20px;
    font-size: 14px;
}

    </style>
</head>
<body>

    <!-- Page de couverture (exemple) -->
    <div style="text-align: center; margin-top: 100px;">
        <img src="{{ public_path('images/aaaaaaaa.jpeg') }}" alt="Logo" style="width: 150px;">
        <h1>RAPPORT {{ $filterResult }}<br>EQUIPE MRCC<br>2024</h1>
    </div>
    <div style="page-break-before: always;"></div>

    <!-- Sommaire -->
    <div class="summary-container">
        <div class="summary-header">SOMMAIRE</div>
        <div class="summary-content">
            <p><strong>1. EVENEMENTS SAR</strong></p>
            <p class="ml-5">1.1. TYPES D'INCIDENTS</p>
            <p class="ml-5">1.2. CAUSES DES INCIDENTS</p>
            <p class="ml-5">1.3. LOCALISATION DES INCIDENTS</p>
            <p class="ml-5">1.4. BILAN HUMAIN</p><br>

            <p><strong>2. AVIS AUX NAVIGATEURS</strong></p><br>

            <p><strong>3. SUIVI DU TRAFIC MARITIME DANS LA ZEE DE MADAGASCAR</strong></p><br>
            <p class="ml-5">3.1. SUIVI DES NAVIRES PARTICULIERS</p><br>
            <p class="ml-5">3.2. SUIVI DES NAVIRES DANS LES MERS TERRITORIALES (PORTS INCLUS)</p>
            <p class="ml-6">3.2.1. DELIMITATION DES ZONES DE SURVEILLANCE</p>
            <p class="ml-6">3.2.2. LISTE DES NAVIRES PAR ZONE</p>
            <p class="ml-6">3.2.3. RECAPITULATIF SUIVI CABOTAGE NATIONAL</p>
            <p class="ml-6">3.2.4. RECAPITULATIF ARRIVEE NAVIRES ETRANGERS</p>
            <p class="ml-6">3.2.5. RECAPITULATIF LISTE NAVIRES DE PASSAGE INOFFENSIF</p>
            <p class="ml-5">3.3. RECAPITULATION ZEE</p><br>

            <p><strong>4. RECAPITULATIF ACTIVITES VEDETTES SAR</strong></p>
            <p><strong>5. POLLUTION</strong></p>
            <p><strong>6. AUTRES</strong></p>
        </div>
    </div>
    <div style="page-break-before: always;"></div>
    <!-- Suite du rapport : vos graphiques, tableaux, etc. -->
    <div style=\"page-break-before: always;\"></div>

    <!-- Sections avec graphiques (déjà dans votre code) -->
<!-- Exemple de section pour les Types d'Événements -->
    <div class="sar-section">
        <!-- Titre principal (ex. "1. EVENEMENTS SAR") -->
        <h2>1. EVENEMENTS SAR</h2>

        <!-- Sous-titre (ex. "1.1 TYPES D'INCIDENTS") -->
        <h3>1.1 TYPES D'INCIDENTS</h3>

        <!-- Paragraphe descriptif (ex. nombre d'incidents, détails...) -->


        <!-- Section du graphique -->
        @if(isset($typesChartUrl) && isset($typesData))
        <p>
            @php
                $totalCount = 0; // Initialiser la variable pour stocker le total
            @endphp

            @foreach($typesData as $type)
                @php
                    $totalCount += $type['count']; // Ajouter la valeur de 'count' au total
                @endphp
            @endforeach
            Nous avons enregistré {{$totalCount}} incidents en mer durant {{ $filterResult }}.
            En effet, nous avons noté 
            @foreach($typesData as $type)
                {{ $type['count'] }} {{ $type['name'] }} ,
            @endforeach

        </p>
        <div class="chart-section">
            <!-- Titre au-dessus du graphique -->
            <h4>TYPE D'INCIDENTS</h4>

            <!-- Image du graphique QuickChart -->
            <div class="chart-image">
                <img src="{{ $typesChartUrl }}" alt="Graphique Types">
            </div>

            <!-- Description ou légende du graphique -->
            <div class="chart-desc">
                <p> (Cf. figure 1)</p>
            </div>
        </div>
        @endif
    </div>
    
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
