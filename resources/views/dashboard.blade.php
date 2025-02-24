@extends('general.top')

@section('title', 'DASHBOARD')

@section('content')

<div class="container-fluid px-4">

    <!-- LES 4 BOÎTES EN HAUT DU DASHBOARD -->
    <div class="row mt-4">
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #4CAF50; color: white;">
                <div class="inner">
                    <h3>{{ $avurnavCount }}</h3>
                    <p>Nombre d'Avurnav</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('avurnav.index') }}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #FF9800; color: white;">
                <div class="inner">
                    <h3>{{ $pollutionCount }}</h3>
                    <p>Nombre de Pollutions</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('pollutions.index') }}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #F44336; color: white;">
                <div class="inner">
                    <h3>{{ $sitrepCount }}</h3>
                    <p>Nombre de Sitrep</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('sitreps.index') }}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #2196F3; color: white;">
                <div class="inner">
                    <h3>{{ $bilanSarCount }}</h3>
                    <p>Nombre de BilanSar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('bilan_sars.index') }}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- LES 4 GRAPHES EN DESSOUS -->
        <div class="row mt-4">
            <!-- Graphique Nombre d'Éléments par Modèle -->
            <!-- Graphique des Types d'Événements -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: #4CAF50; color: white;">
                        <h5>Répartition des Types d'Événements</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartTypes"></canvas>
                    </div>
                </div>
            </div>

            <!-- Graphique des Causes d'Événements -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Répartition des Causes d'Événements</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartCauses"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclure Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données des types d'événements
    const typesLabels = @json($typesData->pluck('name'));
    const typesCounts = @json($typesData->pluck('count'));

    // Données des causes d'événements
    const causesLabels = @json($causesData->pluck('name'));
    const causesCounts = @json($causesData->pluck('count'));

    // Graphique des Types d'Événements
    new Chart(document.getElementById('chartTypes').getContext('2d'), {
        type: 'bar',
        data: {
            labels: typesLabels,
            datasets: [{
                label: 'Nombre d\'événements',
                backgroundColor: '#4CAF50',
                data: typesCounts
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Graphique des Causes d'Événements
    new Chart(document.getElementById('chartCauses').getContext('2d'), {
        type: 'bar',
        data: {
            labels: causesLabels,
            datasets: [{
                label: 'Nombre d\'événements',
                backgroundColor: '#FF9800',
                data: causesCounts
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
