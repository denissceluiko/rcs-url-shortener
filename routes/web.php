<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinkController::class, 'index'])->name('link.index');

Route::get('/dashboard', [LinkController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/lang/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'lv'])) {
        abort(400);
    }

    session(['lang' => $locale]);

    return back();
})->name('language');

Route::post('/create', [LinkController::class, 'store'])->name('link.store');
Route::post('/destory', [LinkController::class, 'destroy'])->middleware(['auth'])->name('link.destroy');
Route::get('{slug}', [LinkController::class, 'route'])->name('link.route');
Route::get('{slug}/qr', [LinkController::class, 'qr'])->name('link.qr');
Route::get('{slug}/qr-download', [LinkController::class, 'qrDownload'])->name('link.qr-download');
Route::get('{slug}/edit', [LinkController::class, 'edit'])->middleware(['auth'])->name('link.edit');
Route::patch('{slug}', [LinkController::class, 'update'])->middleware(['auth'])->name('link.update');

