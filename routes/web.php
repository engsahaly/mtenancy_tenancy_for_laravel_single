<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        
        
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('/dashboard', function () {
            $users = User::all();
            return view('dashboard', get_defined_vars());
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        require __DIR__.'/auth.php';

    });
}


