<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/clients', [UserController::class, 'index'])->name('users.clients')->middleware('worker');

    Route::resource('books', BookController::class);
    Route::put('books/{book}/restore', [BookController::class, 'restore'])->name('books.restore')->middleware('worker');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::put('/reservations/{book}/reserve', [ReservationController::class, 'reserve'])->name('reservations.reserve')->middleware('client');
    Route::put('/reservations/{book}/return', [ReservationController::class, 'return'])->name('reservations.return')->middleware('client');
});

require __DIR__.'/auth.php';
