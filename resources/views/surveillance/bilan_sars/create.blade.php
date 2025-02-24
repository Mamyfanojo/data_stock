@extends('general.top')

@section('title', 'CREER BILAN SAR')

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

    <h2 class="mb-4 text-center">📜 Créer BILAN SAR</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bilan_sars.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label>Date</label>
                <input type="date" name="date" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Nom du Navire</label>
                <input type="text" name="nom_du_navire" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Pavillon</label>
                <input type="text" name="pavillon" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Immatriculation/Callsign</label>
                <input type="text" name="immatriculation_callsign" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Armateur/Propriétaire</label>
                <input type="text" name="armateur_proprietaire" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Type du Navire</label>
                <input type="text" name="type_du_navire" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Coque</label>
                <input type="text" name="coque" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Propulsion</label>
                <input type="text" name="propulsion" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Moyen d'Alerte</label>
                <input type="text" name="moyen_d_alerte" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Type d'Événement</label>
                <select name="type_d_evenement_id" class="form-control">
                    @foreach ($types_evenement as $type)
                        <option value="{{ $type->id }}">{{ $type->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Cause de l'Événement</label>
                <select name="cause_de_l_evenement_id" class="form-control">
                    @foreach ($causes_evenement as $cause)
                        <option value="{{ $cause->id }}">{{ $cause->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Description de l'Événement</label>
                <textarea name="description_de_l_evenement" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
                <label>Lieu de l'Événement</label>
                <input type="text" name="lieu_de_l_evenement" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label>Région</label>
                <select name="region_id" class="form-control">
                    <option value="">Sélectionner une région</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label>Type d'Intervention</label>
                <input type="text" name="type_d_intervention" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Description de l'Intervention</label>
                <textarea name="description_de_l_intervention" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
                <label>Source de l'Information</label>
                <input type="text" name="source_de_l_information" class="form-control">
            </div>
            <div class="col-md-6">
                <label>POB</label>
                <input type="number" name="pob" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Survivants</label>
                <input type="number" name="survivants" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Blessés</label>
                <input type="number" name="blesses" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Morts</label>
                <input type="number" name="morts" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Disparus</label>
                <input type="number" name="disparus" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Évasan</label>
                <input type="number" name="evasan" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Bilan Matériel</label>
                <textarea name="bilan_materiel" class="form-control"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
    </form>
</div>
@endsection