@extends('general.top')

@section('title', 'EDIT TYPE D\' EVENEMENT')

@section('content')

<div class="container-fluid px-4">
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('type_evenements.create') }}">Créer cause</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('type_evenements.index') }}">Liste des causes</a>
        </button>
    </div>
    <h2 class="mb-4 text-center">Modifier le type d'événement</h2>
    <form action="{{ route('type_evenements.update', $typeEvenement) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" value="{{ $typeEvenement->nom }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection