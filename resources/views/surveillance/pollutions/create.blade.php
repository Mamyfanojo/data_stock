@extends('general.top')

@section('title', 'CREER POLLUTION')

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
    <h2 class="mb-4 text-center">📜 Ajouter POLLUTION</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('pollutions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="numero" class="form-label">Numéro :</label>
            <input type="text" id="numero" name="numero" value="{{ old('numero') }}" class="form-control forma" required>
        </div>
        <div class="mb-3">
            <label for="zone" class="form-label">Zone :</label>
            <input type="text" id="zone" name="zone" value="{{ old('zone') }}" class="form-control forma" required>
        </div>
        <div class="mb-3">
            <label for="coordonnees" class="form-label">Coordonnées géographiques :</label>
            <input type="text" id="coordonnees" name="coordonnees" value="{{ old('coordonnees') }}" class="form-control forma" required>
        </div>
        <div class="mb-3">
            <label for="type_pollution" class="form-label">Type de pollution :</label>
            <input type="text" id="type_pollution" name="type_pollution" value="{{ old('type_pollution') }}" class="form-control forma" required>
        </div>
        <div class="mb-3">
            <label for="image_satellite" class="form-label">Image satellite :</label>
            <!-- <input type="file" id="image_satellite" name="image_satellite" class="form-control forma" accept="image/*"> -->
            <input type="file" name="images[]" multiple accept="image/*" class="form-control forma" >
            <!-- <input type="file" id="image_satellite" name="image_satellite"  multiple accept="image/*" class="form-control forma" > -->
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('pollutions.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection