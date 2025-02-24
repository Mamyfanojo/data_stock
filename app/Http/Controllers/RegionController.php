<?php
namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller {
    public function index() {
        $regions = Region::paginate(10);
        return view('surveillance.bilan_sars.regions.index', compact('regions'));
    }

    public function create() {
        return view('surveillance.bilan_sars.regions.create');
    }

    public function store(Request $request) {
        $request->validate(['nom' => 'required|string|max:255']);
        Region::create($request->all());
        return redirect()->route('type_evenements.index')->with('success', 'Type ajouté avec succès.');
    }

    public function edit(Region $region) {
        return view('surveillance.bilan_sars.regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region) {
        $request->validate(['nom' => 'required|string|max:255']);
        $region->update($request->all());
        return redirect()->route('regions.index')->with('success', 'Type mis à jour.');
    }

    public function destroy(Region $typeEvenement) {
        $typeEvenement->delete();
        return redirect()->route('regions.index')->with('success', 'Type supprimé.');
    }
}
