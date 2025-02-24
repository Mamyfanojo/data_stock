@extends('general.top')

@section('title', 'LISTES BILAN SAR')

@section('content')

<div class="container-fluid px-4">

    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('bilan_sars.create') }}">Créer bilan_sars</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('bilan_sars.index') }}">Liste bilan_sars</a>
        </button>
    </div>

    <h2 class="mb-4 text-center">📜 Liste des Données BILAN SAR</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Formulaire d'importation CSV --}}
    <!-- <div class="card p-3 mb-4">
        <h5>📥 Importer un fichier CSV</h5>
        <form action="{{ route('bilan_sars.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="csv_file" class="form-control" required accept=".csv">
            </div>
            <button type="submit" class="btn btn-primary">Importer</button>
        </form>
    </div> -->

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Nom du Navire</th>
                    <th>Pavillon</th>
                    <th>Immatriculation/Callsign</th>
                    <th>Armateur/Propriétaire</th>
                    <th>Type du Navire</th>
                    <th>Coque</th>
                    <th>Propulsion</th>
                    <th>Moyen d'Alerte</th>
                    <th>Type d'Événement</th>
                    <th>Cause de l'Événement</th>
                    <th>Description de l'Événement</th>
                    <th>Lieu de l'Événement</th>
                    <th>Région</th>
                    <th>Type d'Intervention</th>
                    <th>Description de l'Intervention</th>
                    <th>Source de l'Information</th>
                    <th>POB</th>
                    <th>Survivants</th>
                    <th>Blessés</th>
                    <th>Morts</th>
                    <th>Disparus</th>
                    <th>Évasan</th>
                    <th>Bilan Matériel</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bilans as $bilan)
                    <tr>
                        <td><small>{{ $bilan->date }}</small></td>
                        <td><small>{{ $bilan->nom_du_navire }}</small></td>
                        <td><small>{{ $bilan->pavillon }}</small></td>
                        <td><small>{{ $bilan->immatriculation_callsign }}</small></td>
                        <td><small>{{ $bilan->armateur_proprietaire }}</small></td>
                        <td><small>{{ $bilan->type_du_navire }}</small></td>
                        <td><small>{{ $bilan->coque }}</small></td>
                        <td><small>{{ $bilan->propulsion }}</small></td>
                        <td><small>{{ $bilan->moyen_d_alerte }}</small></td>
                        <td><small>{{ $bilan->typeEvenement->nom ?? '-' }}</small></td>
                        <td><small>{{ $bilan->causeEvenement->nom ?? '-' }}</small></td>
                        <td><small>{{ $bilan->description_de_l_evenement }}</small></td>
                        <td><small>{{ $bilan->lieu_de_l_evenement }}</small></td>
                        <td><small>{{ $bilan->region?->nom }}</small></td>
                        <td><small>{{ $bilan->type_d_intervention }}</small></td>
                        <td><small>{{ $bilan->description_de_l_intervention }}</small></td>
                        <td><small>{{ $bilan->source_de_l_information }}</small></td>
                        <td><small>{{ $bilan->pob }}</small></td>
                        <td><small>{{ $bilan->survivants }}</small></td>
                        <td><small>{{ $bilan->blesses }}</small></td>
                        <td><small>{{ $bilan->morts }}</small></td>
                        <td><small>{{ $bilan->disparus }}</small></td>
                        <td><small>{{ $bilan->evasan }}</small></td>
                        <td><small>{{ $bilan->bilan_materiel }}</small></td>
                        <td>
                            <form action="{{ route('bilan_sars.destroy', $bilan->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet élément ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="26" class="text-center text-muted">Aucune donnée enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection