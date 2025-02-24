@extends('general.top')

@section('title', 'CREER EVENEMENT')

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
    <h2 class="mb-4 text-center">Créer une Cause d'Événement</h2>
    <form action="{{ route('cause_evenements.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection