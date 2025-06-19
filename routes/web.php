<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TicketTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Tiket
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('tickets.index');

    // Rute untuk Verifikasi Tiket
    Route::get('/ticket-verify', [VerificationController::class, 'index'])->name('ticket.verify.form');
    Route::post('/ticket-verify', [VerificationController::class, 'verify'])->name('ticket.verify.process');

    // Rute untuk Pengaturan Jenis Tiket (dilindungi oleh middleware 'admin')
    Route::prefix('admin/ticket-types')->name('ticket_types.')->middleware('admin')->group(function () {
        Route::get('/', [TicketTypeController::class, 'index'])->name('index');
        Route::get('/create', [TicketTypeController::class, 'create'])->name('create'); // <--- RUTE BARU: untuk menampilkan form tambah
        Route::post('/', [TicketTypeController::class, 'store'])->name('store');       // <--- RUTE BARU: untuk menyimpan data
        Route::get('/{ticketType}/edit', [TicketTypeController::class, 'edit'])->name('edit');
        Route::put('/{ticketType}', [TicketTypeController::class, 'update'])->name('update');
        Route::delete('/{ticketType}', [TicketTypeController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';