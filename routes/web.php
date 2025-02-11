<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/export-articles', [ArticleController::class, 'exportCSV'])->name('articles.export');

Route::post('/import-articles', [ArticleController::class, 'importCSV'])->name('articles.import');

Route::get('/articles/filter', [ArticleController::class, 'filter'])->name('articles.filter');

Route::get('/articles/export-filtered', [ArticleController::class, 'exportFilteredCSV'])->name('articles.export.filtered');

Route::resource('articles', ArticleController::class);
