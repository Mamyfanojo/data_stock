<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'flag' => 'nullable|string|max:255',
            'vessel_name' => 'nullable|string|max:255',
            'registered_owner' => 'nullable|string|max:255',
            'call_sign' => 'nullable|string|max:255',
            'mmsi' => 'nullable|string|max:255',
            'imo' => 'nullable|string|max:255',
            'ship_type' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'eta' => 'nullable|date', // Validation pour la date ETA
            'navigation_status' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric', // Validation pour la latitude
            'longitude' => 'nullable|numeric', // Validation pour la longitude
            'age' => 'nullable|integer', // Validation pour l'âge
            'time_of_fix' => 'nullable',
        ]);

        $data = $request->all();
        $data['time_of_fix'] = $this->formatTimeOfFix($request->input('time_of_fix'));

        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'Article ajouté avec succès.');
    }


    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'flag' => 'nullable|string|max:255',
            'vessel_name' => 'nullable|string|max:255',
            'registered_owner' => 'nullable|string|max:255',
            'call_sign' => 'nullable|string|max:255',
            'mmsi' => 'nullable|string|max:255',
            'imo' => 'nullable|string|max:255',
            'ship_type' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'eta' => 'nullable',
            'navigation_status' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'time_of_fix' => 'nullable',
        ]);

        $data = $request->all();
        $data['time_of_fix'] = $this->formatTimeOfFix($request->input('time_of_fix'));

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé.');
    }

    public function exportCSV()
    {
        $articles = Article::all();
        $fileName = 'articles.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($articles) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM pour UTF-8

            fputcsv($file, ['flag', 'vessel_name', 'registered_owner', 'call_sign', 'mmsi', 'imo', 'ship_type', 'destination', 'eta', 'navigation_status', 'latitude', 'longitude', 'age', 'time_of_fix'], ';');

            foreach ($articles as $article) {
                fputcsv($file, [$article->flag, $article->vessel_name, $article->registered_owner, $article->call_sign, $article->mmsi, $article->imo, $article->ship_type, $article->destination, $article->eta, $article->navigation_status, $article->latitude, $article->longitude, $article->age, $article->time_of_fix], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCSV(Request $request)
    {
        $file = $request->file('csv_file');
        set_time_limit(1200);

        if ($file) {
            $handle = fopen($file->getPathname(), 'r');
            fgetcsv($handle, 1000, ';'); // Ignorer la ligne d'en-tête

            $articles = [];

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                if (count($data) < 14) {
                    continue; // Ignorer les lignes incomplètes
                }

                $timeOfFix = $this->formatTimeOfFix($data[13]);

                $articles[] = [
                    'flag' => $data[0],
                    'vessel_name' => $data[1],
                    'registered_owner' => $data[2],
                    'call_sign' => $data[3],
                    'mmsi' => $data[4],
                    'imo' => $data[5],
                    'ship_type' => $data[6],
                    'destination' => $data[7],
                    'eta' => $data[8],
                    'navigation_status' => $data[9],
                    'latitude' => $data[10],
                    'longitude' => $data[11],
                    'age' => $data[12],
                    'time_of_fix' => $timeOfFix,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($articles) >= 1000) {
                    Article::insert($articles);
                    $articles = [];
                }
            }

            if (!empty($articles)) {
                Article::insert($articles);
            }

            fclose($handle);
        }

        return back()->with('success', 'Importation terminée.');
    }

    private function formatTimeOfFix(?string $timeOfFix): ?string
    {
        if ($timeOfFix) {
            try {
                if (strpos($timeOfFix, 'Z') !== false) {
                    return Carbon::parse($timeOfFix)->timezone(config('app.timezone'))->toDateTimeString();
                } else {
                    return Carbon::parse($timeOfFix)->timezone(config('app.timezone'))->toDateTimeString();
                }
            } catch (\Throwable $th) {
                Log::error("Erreur lors du formatage de time_of_fix : " . $th->getMessage());
                return null;
            }
        }

        return null;
    }
}