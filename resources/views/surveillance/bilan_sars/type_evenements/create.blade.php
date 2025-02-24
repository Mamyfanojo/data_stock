@extends('general.top')

@section('title', 'CREER TYPE')

@section('content')

<div class="container-fluid px-4">

    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('type_evenements.create') }}">Créer type</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('type_evenements.index') }}">Liste des types d'evenements</a>
        </button>
    </div>

    <h2 class="mb-4 text-center">Créer une type d'Événement</h2>
    <form action="{{ route('type_evenements.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
    
</div>
@endsection