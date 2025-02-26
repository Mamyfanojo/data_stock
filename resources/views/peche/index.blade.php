@extends('general.top')

@section('title', 'LISTES')

@section('content')

    <div class="container-fluid px-4">
        <h2 class="mb-4 text-center">📜 Pêche</h2>

        <!-- Formulaire d'import CSV -->
        <div class="card p-3 mb-4 shadow-sm">
            <form action="{{ route('peche.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="csv_file" class="form-control" required>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Importer CSV</button>
                </div>
            </form>
        </div>

        <!-- TABLE RESPONSIVE -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Flag</th>
                        <th>Vessel Name</th>
                        <th>Registered Owner</th>
                        <th>Call Sign</th>
                        <th>MMSI</th>
                        <th>IMO</th>
                        <th>Ship Type</th>
                        <th>Destination</th>
                        <th>ETA</th>
                        <th>Navigation Status</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Age</th>
                        <th>Time Of Fix</th>
                        <th style="width: 120px;">Actions</th> <!-- Agrandissement de la colonne -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peches as $peche)
                        <tr>
                            <td><small>{{ $peche->id }}</small></td>
                            <td><small>{{ $peche->flag }}</small></td>
                            <td><small>{{ $peche->vessel_name }}</small></td>
                            <td><small>{{ $peche->registered_owner }}</small></td>
                            <td><small>{{ $peche->call_sign }}</small></td>
                            <td><small>{{ $peche->mpechemsi }}</small></td>
                            <td><small>{{ $peche->imo }}</small></td>
                            <td><small>{{ $peche->ship_type }}</small></td>
                            <td><small>{{ $peche->destination }}</small></td>
                            <td><small>{{ $peche->eta }}</small></td>
                            <td><small>{{ $peche->navigation_status }}</small></td>
                            <td><small>{{ $peche->latitude }}</small></td>
                            <td><small>{{ $peche->longitude }}</small></td>
                            <td><small>{{ $peche->age }}</small></td>
                            <td><small>{{ $peche->time_of_fix }}</small></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('peche.destroy', $peche->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $peches->links() }}
        </div>

    <style>
        
        .pagination {
            flex-wrap: wrap; /* Empêche le débordement */
            justify-content: center; /* Centre la pagination */
        }
    </style>
@endsection