<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\UserProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\DocumentUploadedNotification;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function create(UserProcedure $userProcedure)
    {
        $this->authorize("update", $userProcedure);

        // Cargar los requisitos asociados al trámite
        $requirements = $userProcedure->procedure->requirements;
        return view("documents.create", compact("userProcedure", "requirements"));
    }

    public function store(Request $request, UserProcedure $userProcedure)
    {
        $this->authorize("update", $userProcedure);

        try {
            Log::debug('Iniciando subida de documento', ['user_procedure_id' => $userProcedure->id, 'session_id' => session()->getId(), 'csrf_token' => csrf_token()]);

            $validated = $request->validate([
                "requirement_id" => "required|exists:procedure_requirements,id",
                "file" => "required|file|mimes:jpg,png,pdf|max:2048",
            ]);

            $file = $request->file("file");
            $path = $file->store("documents", "public");

            $document = Document::create([
                "user_procedure_id" => $userProcedure->id,
                "procedure_requirement_id" => $validated["requirement_id"],
                "file_path" => $path,
                "status" => "pending",
            ]);

            // Notificar al administrador
            $admin = User::where("role", "admin")->first();
            if ($admin) {
                $admin->notify(new DocumentUploadedNotification($document));
            }

            return redirect()->route("procedures.show", $userProcedure)->with("success", "Documento subido correctamente.");
        } catch (\Exception $e) {
            Log::error("Error al subir documento: " . $e->getMessage(), [
                'request' => $request->all(),
                'user_procedure_id' => $userProcedure->id,
                'session_id' => session()->getId(),
                'csrf_token' => csrf_token(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with("error", "Error al subir el documento. Por favor, intenta de nuevo. Detalle: " . $e->getMessage());
        }
    }
}
