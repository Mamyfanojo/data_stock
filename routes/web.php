<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ListeMadaController;
use App\Http\Controllers\AvurnavController;
use App\Http\Controllers\SitrepController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\PollutionController;
use App\Http\Controllers\BilanSarController;
use App\Http\Controllers\TypeEvenementController;
use App\Http\Controllers\CauseEvenementController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\test;

// WELCOME
Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ARTICLES
Route::get('/export-articles', [ArticleController::class, 'exportCSV'])->name('articles.export');
Route::post('/import-articles', [ArticleController::class, 'importCSV'])->name('articles.import');
Route::get('/articles/filter', [ArticleController::class, 'filter'])->name('articles.filter');
Route::get('/articles/export-filtered', [ArticleController::class, 'exportFilteredCSV'])->name('articles.export.filtered');
Route::resource('articles', ArticleController::class);

// LISTMADA
Route::get('/listeMada', [ListeMadaController::class, 'index'])->name('list.mada');
Route::delete('/listeMada/{id}/destroy', [ListeMadaController::class, 'index'])->name('listmadas.destroy');
Route::get('/export-listmada', [ListeMadaController::class, 'export'])->name('listmadas.export');
Route::post('/import-listmada', [ListeMadaController::class, 'import'])->name('listmadas.import');


// AVURNAV
Route::get('/export-pdf_nav/{id}', [AvurnavController::class, 'exportPDF'])->name('export.pdf');
Route::get('/avurnav', [AvurnavController::class, 'index'])->name('avurnav.index');
Route::get('/avurnav/create', [AvurnavController::class, 'create'])->name('avurnav.create');
Route::post('/avurnav/store', [AvurnavController::class, 'store']);


// POLLUTION
Route::resource('pollutions', PollutionController::class);
Route::get('/export-pdf/{id}', [PollutionController::class, 'exportPDF'])->name('pollutions.exportPDF');

// SITREP
Route::resource('sitreps', SitrepController::class);
Route::get('/sitreps/{id}/export-pdf', [SitrepController::class, 'exportPDF'])->name('sitreps.exportPDF');


// ZONES
Route::get('/zone/{id}', [ZoneController::class, 'show'])->name('zone.show');
Route::get('/zone/1', [ZoneController::class, 'show'])->name('zone.show1');
Route::post('/import-articles/{id}', [ZoneController::class, 'importCSV'])->name('zone.import');


//TYPE ET CAUSE EVENEMENT
Route::prefix('bilan_sars')->group(function () {
    Route::resource('type_evenements', TypeEvenementController::class);
    Route::resource('cause_evenements', CauseEvenementController::class);
    Route::resource('regions', RegionController::class);
});


Route::resource('bilan_sars', BilanSarController::class)->except(['edit', 'update', 'show']);
Route::get('general', [test::class, 'index']);
Route::post('/bilan_sars/import', [BilanSarController::class, 'import'])->name('bilan_sars.import');
