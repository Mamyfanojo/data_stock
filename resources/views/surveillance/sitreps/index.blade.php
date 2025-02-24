@extends('general.top')

@section('title', 'LISTES AVURNAV')

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
    <h2 class="mb-4 text-center">📜 Liste des SITREPS</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>SITREP SAR</th>
                    <th>MRCC Madagascar</th>
                    <th>Event</th>
                    <th>Situation</th>
                    <th>Number of Persons</th>
                    <th>Assistance Required</th>
                    <th>Coordinating RCC</th>
                    <th>Initial Action Taken</th>
                    <th>Chronology</th>
                    <th>Additional Information</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sitreps as $sitrep)
                    <tr>
                        <td><small>{{ $sitrep->id }}</small></td>
                        <td><small>{{ $sitrep->sitrep_sar }}</small></td>
                        <td><small>{{ $sitrep->mrcc_madagascar }}</small></td>
                        <td><small>{{ $sitrep->event }}</small></td>
                        <td><small>{{ $sitrep->situation }}</small></td>
                        <td><small>{{ $sitrep->number_of_persons }}</small></td>
                        <td><small>{{ $sitrep->assistance_required }}</small></td>
                        <td><small>{{ $sitrep->coordinating_rcc }}</small></td>
                        <td><small>{{ $sitrep->initial_action_taken }}</small></td>
                        <td><small>{{ $sitrep->chronology }}</small></td>
                        <td><small>{{ $sitrep->additional_information }}</small></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('sitreps.exportPDF', $sitrep->id) }}" class="btn btn-secondary btn-sm">Exporter</a>
                                
                                <form action="{{ route('sitreps.destroy', $sitrep->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette pollution ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection