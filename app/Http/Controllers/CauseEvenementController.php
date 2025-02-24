<?php
namespace App\Http\Controllers;

use App\Models\CauseEvenement;
use Illuminate\Http\Request;

class CauseEvenementController extends Controller {
    public function index() {
        $causes = CauseEvenement::paginate(10);
        return view('surveillance.bilan_sars.cause_evenements.index', compact('causes'));
    }

    public function create() {
        return view('surveillance.bilan_sars.cause_evenements.create');
    }

    public function store(Request $request) {
        $request->validate(['nom' => 'required|string|max:255']);
        CauseEvenement::create($request->all());
        return redirect()->route('cause_evenements.index')->with('success', 'Cause ajoutée avec succès.');
    }

    public function edit(CauseEvenement $causeEvenement) {
        return view('surveillance.bilan_sars.cause_evenements.edit', compact('causeEvenement'));
    }

    public function update(Request $request, CauseEvenement $causeEvenement) {
        $request->validate(['nom' => 'required|string|max:255']);
        $causeEvenement->update($request->all());
        return redirect()->route('cause_evenements.index')->with('success', 'Cause mise à jour.');
    }

    public function destroy(CauseEvenement $causeEvenement) {
        $causeEvenement->delete();
        return redirect()->route('cause_evenements.index')->with('success', 'Cause supprimée.');
    }
}