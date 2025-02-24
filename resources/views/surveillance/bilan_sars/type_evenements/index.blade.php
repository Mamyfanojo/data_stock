@extends('general.top')

@section('title', 'LISTES TYPES D\'EVENEMENT')

@section('content')

<div class="container-fluid px-4">

    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('type_evenements.create') }}">Créer type</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('type_evenements.index') }}">Liste des types</a>
        </button>
    </div>

    <h2 class="mb-4 text-center">📜 Liste des types d'evenements</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
        @foreach($types as $type)
        <tr>
            <td><small>{{ $type->id }}</small></td>
            <td><small>{{ $type->nom }}</small></td>
            <td>
                <a href="{{ route('type_evenements.edit', $type) }}" class="btn btn-secondary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('type_evenements.destroy', $type) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </table>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $types->links() }}
    </div>
</div>
@endsection