<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [LinkController::class, 'index'])->name('link.index');
Route::post('/create', [LinkController::class, 'store'])->name('link.store');
Route::post('/destory', [LinkController::class, 'destroy'])->name('link.destroy');
Route::get('{slug}', [LinkController::class, 'route'])->name('link.route');
