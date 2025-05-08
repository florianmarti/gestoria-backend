<?php

use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminProcedureController;
use App\Http\Controllers\AdminRequirementController;
use App\Http\Controllers\AdminNotificationController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/dashboard", function () {
    return view("dashboard");
})->middleware(["auth", "verified"])->name("dashboard");

Route::middleware("auth")->group(function () {
    // Rutas para gestión de perfil
    Route::prefix("profile")->group(function () {
        Route::get("/", [ProfileController::class, "edit"])->name("profile.edit");
        Route::patch("/", [ProfileController::class, "update"])->name("profile.update");
        Route::delete("/", [ProfileController::class, "destroy"])->name("profile.destroy");
    });

    // Rutas para trámites de usuario
    Route::prefix("procedures")->group(function () {
        Route::get("/", [ProcedureController::class, "index"])->name("procedures.index");
        Route::get("/create", [ProcedureController::class, "create"])->name("procedures.create");
        Route::post("/", [ProcedureController::class, "store"])->name("procedures.store");
        Route::get("/{userProcedure}", [ProcedureController::class, "show"])->name("procedures.show");
        Route::delete("/{userProcedure}", [ProcedureController::class, "destroy"])->name("procedures.destroy");

        // Subrutas para documentos
        Route::prefix("{userProcedure}/documents")->group(function () {
            Route::get("/create", [DocumentController::class, "create"])->name("documents.create");
            Route::post("/", [DocumentController::class, "store"])->name("documents.store");
        });
    });

    // Rutas de administración
    Route::middleware("role:admin")->prefix("admin")->group(function () {
        // Procedimientos administrativos
        Route::prefix("procedures")->group(function () {
            Route::get("/", [AdminProcedureController::class, "index"])->name("admin.procedures.index");
            Route::get("/create", [AdminProcedureController::class, "create"])->name("admin.procedures.create");
            Route::post("/", [AdminProcedureController::class, "store"])->name("admin.procedures.store");
            Route::get("/{procedure}/edit", [AdminProcedureController::class, "edit"])->name("admin.procedures.edit");
            Route::patch("/{procedure}", [AdminProcedureController::class, "update"])->name("admin.procedures.update");
            Route::delete("/admin/procedures/{procedure}", [AdminProcedureController::class, "destroy"])->name("admin.procedures.destroy");
        });

        // Requisitos administrativos
        Route::prefix("requirements")->group(function () {
            Route::get("/", [AdminRequirementController::class, "index"])->name("admin.requirements.index");
            Route::get("/create", [AdminRequirementController::class, "create"])->name("admin.requirements.create");
            Route::post("/", [AdminRequirementController::class, "store"])->name("admin.requirements.store");
            Route::get("/{requirement}/edit", [AdminRequirementController::class, "edit"])->name("admin.requirements.edit");
            Route::patch("/{requirement}", [AdminRequirementController::class, "update"])->name("admin.requirements.update");
            Route::delete("/admin/requirements/{requirement}", [AdminRequirementController::class, "destroy"])->name("admin.requirements.destroy");
        });
        // Documentos administrativos
            Route::prefix("documents")->group(function () {
            Route::get("/", [AdminDocumentController::class, "index"])->name("admin.documents.index");
            Route::delete("/{document}", [AdminDocumentController::class, "destroy"])->name("admin.documents.destroy");
            Route::patch("/{document}/approve", [AdminDocumentController::class, "approve"])->name("admin.documents.approve");
            Route::patch("/{document}/reject", [AdminDocumentController::class, "reject"])->name("admin.documents.reject");
        });
        // Notificaciones administrativas
        Route::get("/notifications", [AdminNotificationController::class, "index"])->name("admin.notifications.index");
    });
});

require __DIR__."/auth.php";
