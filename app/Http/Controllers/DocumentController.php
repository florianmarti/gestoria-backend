<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\UserProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra el formulario para subir un documento.
     */
    public function create(UserProcedure $userProcedure)
    {
        $this->authorize('view', $userProcedure);
        $requirements = $userProcedure->procedure->requirements->unique('id');
        $existingDocuments = $userProcedure->documents->keyBy('procedure_requirement_id');
        return view('documents.create', compact('userProcedure', 'requirements', 'existingDocuments'));
    }

    /**
     * Procesa la carga del documento.
     */
    public function store(Request $request, UserProcedure $userProcedure)
{
    $this->authorize('view', $userProcedure);

    $request->validate([
        'requirement_id' => 'required|exists:procedure_requirements,id',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Cambiado de file.* a file
    ]);

    $requirement = $userProcedure->procedure->requirements->find($request->requirement_id);
    if (!$requirement) {
        return response()->json([
            'success' => false,
            'message' => 'El requisito no pertenece a este trámite.',
        ], 422);
    }

    if ($requirement->type !== 'file') {
        return response()->json([
            'success' => false,
            'message' => 'El requisito seleccionado no es de tipo archivo.',
        ], 422);
    }

    // Manejo del archivo único (Dropzone envía uno a la vez)
    $file = $request->file('file');
    $path = $file->store('documents', 'public');

    $document = Document::create([
        'user_procedure_id' => $userProcedure->id,
        'procedure_requirement_id' => $request->requirement_id,
        'file_path' => $path,
        'status' => 'pending',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Archivo subido con éxito.',
        'document' => $document,
        'file_path' => Storage::url($path) // URL pública del archivo
    ], 200);
}
}
