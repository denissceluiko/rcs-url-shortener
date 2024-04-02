<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\Admin\UserController;
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

Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function() {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::prefix('user')->name('user.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::patch('{user}', [UserController::class, 'update'])->name('update');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('link')->name('link.')->group(function() {
        Route::get('/', [AdminLinkController::class, 'index'])->name('index');
        Route::post('destroy', [AdminLinkController::class, 'destroy'])->name('destroy');
        Route::get('{slug}/edit', [AdminLinkController::class, 'edit'])->name('edit');
    });
});

Route::post('/create', [LinkController::class, 'store'])->name('link.store');
Route::post('/destroy', [LinkController::class, 'destroy'])->middleware(['auth'])->name('link.destroy');
Route::get('{slug}', [LinkController::class, 'route'])->name('link.route');
Route::get('{slug}/qr', [LinkController::class, 'qr'])->name('link.qr');
Route::get('{slug}/qr-download', [LinkController::class, 'qrDownload'])->name('link.qr-download');
Route::get('{slug}/edit', [LinkController::class, 'edit'])->middleware(['auth'])->name('link.edit');
Route::patch('{slug}', [LinkController::class, 'update'])->middleware(['auth'])->name('link.update');

