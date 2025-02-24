@extends('general.top')

@section('title', 'LISTES AVURNAV')

@section('content')

<div class="container-fluid px-4">
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('cause_evenements.create') }}">Créer cause</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('cause_evenements.index') }}">Liste des causes</a>
        </button>
    </div>
    <h2 class="mb-4 text-center">📜 Liste des causes d'evenements</h2>
    
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
                @foreach($causes as $cause)
                    <tr>
                        <td><small>{{ $cause->id }}</small></td>
                        <td><small>{{ $cause->nom }}</small></td>
                        <td>
                            <a href="{{ route('cause_evenements.edit', $cause) }}" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('cause_evenements.destroy', $cause) }}" method="POST" style="display:inline;">
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
        {{ $causes->links() }}
    </div>
</div>
@endsection