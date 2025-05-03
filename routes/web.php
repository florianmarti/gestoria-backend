<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminProcedureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas para gestión de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para gestión de trámites
    Route::get('/procedures', [ProcedureController::class, 'index'])->name('procedures.index');
    Route::get('/procedures/create', [ProcedureController::class, 'create'])->name('procedures.create');
    Route::post('/procedures', [ProcedureController::class, 'store'])->name('procedures.store');
    Route::get('/procedures/{userProcedure}', [ProcedureController::class, 'show'])->name('procedures.show');

    // Rutas para gestión de documentos
    Route::get('/procedures/{userProcedure}/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/procedures/{userProcedure}/documents', [DocumentController::class, 'store'])->name('documents.store');

    // Rutas para administración
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/procedures', [AdminProcedureController::class, 'index'])->name('admin.procedures.index');
        Route::get('/admin/procedures/create', [AdminProcedureController::class, 'create'])->name('admin.procedures.create');
        Route::post('/admin/procedures', [AdminProcedureController::class, 'store'])->name('admin.procedures.store');
        Route::get('/admin/procedures/{procedure}/edit', [AdminProcedureController::class, 'edit'])->name('admin.procedures.edit');
        Route::patch('/admin/procedures/{procedure}', [AdminProcedureController::class, 'update'])->name('admin.procedures.update');
    });
});

require __DIR__.'/auth.php';
