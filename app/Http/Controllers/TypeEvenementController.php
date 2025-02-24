<?php
namespace App\Http\Controllers;

use App\Models\TypeEvenement;
use Illuminate\Http\Request;

class TypeEvenementController extends Controller {
    public function index() {
        $types = TypeEvenement::paginate(10);
        return view('surveillance.bilan_sars.type_evenements.index', compact('types'));
    }

    public function create() {
        return view('surveillance.bilan_sars.type_evenements.create');
    }

    public function store(Request $request) {
        $request->validate(['nom' => 'required|string|max:255']);
        TypeEvenement::create($request->all());
        return redirect()->route('type_evenements.index')->with('success', 'Type ajouté avec succès.');
    }

    public function edit(TypeEvenement $typeEvenement) {
        return view('surveillance.bilan_sars.type_evenements.edit', compact('typeEvenement'));
    }

    public function update(Request $request, TypeEvenement $typeEvenement) {
        $request->validate(['nom' => 'required|string|max:255']);
        $typeEvenement->update($request->all());
        return redirect()->route('type_evenements.index')->with('success', 'Type mis à jour.');
    }

    public function destroy(TypeEvenement $typeEvenement) {
        $typeEvenement->delete();
        return redirect()->route('type_evenements.index')->with('success', 'Type supprimé.');
    }
}
