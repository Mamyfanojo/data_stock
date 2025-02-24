@extends('general.top')

@section('title', 'CREER SITREP')

@section('content')


<div class="container-fluid px-4">
    <div class="top-menu">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('sitreps.create') }}">Créer SITREP</a>
        </button>
        <button class="btn btn-secondary">
            <a class="text-decoration-none text-white" href="{{ route('sitreps.index') }}">Liste SITREP</a>
        </button>
    </div>
    <h2 class="mb-4 text-center">Créer SITREP</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sitreps.store') }}" method="POST">
        @csrf
        <div class="row">
        <div class="row">
            @foreach(['sitrep_sar', 'mrcc_madagascar', 'event', 'position', 'situation', 'number_of_persons', 'assistance_required', 'coordinating_rcc', 'initial_action_taken', 'chronology', 'additional_information'] as $index => $field)
                @if($field === 'additional_information')
                    </div> <!-- Ferme la dernière ligne existante -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" name="{{ $field }}" class="form-control" required>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control" required>
                    </div>
                    
                    @if($index % 2 == 1)
                        </div><div class="row">
                    @endif
                @endif
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>

        
    </form>
</div>
@endsection