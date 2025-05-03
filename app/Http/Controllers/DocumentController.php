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
        $requirements = $userProcedure->procedure->requirements;
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
            'file' => 'required_if:type,file|file|mimes:pdf,jpg,png|max:2048', // 2MB máx.
            'value' => 'required_if:type,text|string|max:255',
        ]);

        $requirement = $userProcedure->procedure->requirements->find($request->requirement_id);
        if (!$requirement) {
            return back()->withErrors(['requirement_id' => 'El requisito no pertenece a este trámite.']);
        }

        $data = [
            'user_procedure_id' => $userProcedure->id,
            'procedure_requirement_id' => $request->requirement_id,
            'status' => 'pending',
        ];

        if ($requirement->type === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('documents', 'public');
        } elseif ($requirement->type === 'text') {
            $data['value'] = $request->value;
        } else {
            return back()->withErrors(['file' => 'El tipo de requisito no coincide con los datos proporcionados.']);
        }

        Document::create($data);

        return redirect()->route('procedures.show', $userProcedure)->with('success', 'Documento subido con éxito.');
    }
}
