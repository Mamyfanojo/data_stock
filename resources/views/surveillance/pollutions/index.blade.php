@extends('general.top')

@section('title', 'LISTES POLLUTION')

@section('content')

<div class="container-fluid px-4">
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('pollutions.create') }}">Créer POLLUTION</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('pollutions.index') }}">Liste POLLUTIONS</a>
        </button>
    </div>
    <h2 class="mb-4 text-center">📜 Liste des Données POLLUTIONS</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Zone</th>
                    <th>Coordonnées</th>
                    <th>Type de pollution</th>
                    <th>Image(s)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pollutions as $pollution)
                <tr>
                    <td><small>{{ $pollution->numero }}</small></td>
                    <td><small>{{ $pollution->zone }}</small></td>
                    <td><small>{{ $pollution->coordonnees }}</small></td>
                    <td><small>{{ $pollution->type_pollution }}</small></td>
                    <td>
                        @if ($pollution->images->isNotEmpty())
                            @foreach ($pollution->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="rounded">
                            @endforeach
                        @else
                            <span class="text-muted">Aucune image</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('pollutions.exportPDF', $pollution->id) }}" class="btn btn-secondary btn-sm">Exporter PDF</a>
                            <!-- <a href="{{ route('pollutions.edit', $pollution->id) }}" class="btn btn-warning btn-sm">Modifier</a> -->
                            <form action="{{ route('pollutions.destroy', $pollution->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette pollution ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Aucune pollution enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </ddi
</div>

@endsection