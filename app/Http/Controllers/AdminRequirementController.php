<?php

namespace App\Http\Controllers;

use App\Models\ProcedureRequirement;
use Illuminate\Http\Request;

class AdminRequirementController extends Controller
{
    public function index()
    {
        $requirements = ProcedureRequirement::all();
        return view('admin.requirements.index', compact('requirements'));
    }

    public function create()
    {
        $procedures = \App\Models\Procedure::all(); // Cargar procedimientos para el formulario
        return view('admin.requirements.create', compact('procedures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'name' => 'required|string|max:255',
            'file_type' => 'required|in:file,text',
            'is_required' => 'boolean',
            'description' => 'nullable|string',
        ]);

        ProcedureRequirement::create([
            'procedure_id' => $validated['procedure_id'],
            'name' => $validated['name'],
            'type' => $validated['file_type'],
            'is_required' => $validated['is_required'] ?? false,
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requisito creado con éxito.');
    }

    public function edit(ProcedureRequirement $requirement)
    {
        $procedures = \App\Models\Procedure::all();
        return view('admin.requirements.edit', compact('requirement', 'procedures'));
    }

    public function update(Request $request, ProcedureRequirement $requirement)
    {
        $validated = $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'name' => 'required|string|max:255',
            'file_type' => 'required|in:file,text',
            'is_required' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $requirement->update([
            'procedure_id' => $validated['procedure_id'],
            'name' => $validated['name'],
            'type' => $validated['file_type'],
            'is_required' => $validated['is_required'] ?? false,
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requisito actualizado con éxito.');
    }

    public function destroy(ProcedureRequirement $requirement)
    {
        $requirement->delete();
        return redirect()->route("admin.requirements.index")->with("success", "Requisito eliminado correctamente.");
    }
}
