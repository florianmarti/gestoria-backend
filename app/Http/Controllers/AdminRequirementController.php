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
        return view('admin.requirements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_type' => 'required|in:file',
            'is_required' => 'boolean',
            'description' => 'nullable|string',
        ]);

        ProcedureRequirement::create([
            'name' => $request->name,
            'type' => $request->type,
            'is_required' => $request->is_required ?? false,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requisito creado con éxito.');
    }

    public function edit(ProcedureRequirement $requirement)
    {
        return view('admin.requirements.edit', compact('requirement'));
    }

    public function update(Request $request, ProcedureRequirement $requirement)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_type' => 'required|in:file',
            'is_required' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $requirement->update([
            'name' => $request->name,
            'type' => $request->type,
            'is_required' => $request->is_required ?? false,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requisito actualizado con éxito.');
    }
    public function destroy(ProcedureRequirement $requirement)
    {
        $requirement->delete();
        return redirect()->route("admin.requirements.index")->with("success", "Requisito eliminado correctamente.");
    }
}
