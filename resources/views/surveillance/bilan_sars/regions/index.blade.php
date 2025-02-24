@extends('general.top')

@section('title', 'LISTES REGIONS')

@section('content')

<div class="container-fluid px-4">
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('regions.create') }}">Créer cause</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('regions.index') }}">Liste des regions</a>
        </button>
    </div>
    <h2 class="mb-4 text-center">📜 Liste des regions</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($regions as $region)
                    <tr>
                        <td><small>{{ $region->id }}</small></td>
                        <td><small>{{ $region->nom }}</small></td>
                        <td>
                            <a href="{{ route('regions.edit', $region) }}" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('regions.destroy', $region) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $regions->links() }}
    </div>
</div>
@endsection