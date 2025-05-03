<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\ProcedureRequirement;
use Illuminate\Http\Request;

class AdminProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        return view('admin.procedures.index', compact('procedures'));
    }

    public function create()
    {
        $requirements = ProcedureRequirement::all();
        return view('admin.procedures.create', compact('requirements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:automotor,impositivo,otros',
            'description' => 'nullable|string',
            'fee' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
            'requirements' => 'nullable|array',
            'requirements.*' => 'exists:procedure_requirements,id',
        ]);

        $procedure = Procedure::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'fee' => $request->fee,
            'estimated_days' => $request->estimated_days,
        ]);

        if ($request->requirements) {
            $procedure->requirements()->sync($request->requirements);
        }

        return redirect()->route('admin.procedures.index')->with('success', 'Trámite creado con éxito.');
    }

    public function edit(Procedure $procedure)
    {
        $requirements = ProcedureRequirement::all();
        $selectedRequirements = $procedure->requirements->pluck('id')->toArray();
        return view('admin.procedures.edit', compact('procedure', 'requirements', 'selectedRequirements'));
    }

    public function update(Request $request, Procedure $procedure)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:automotor,impositivo,otros',
            'description' => 'nullable|string',
            'fee' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
            'requirements' => 'nullable|array',
            'requirements.*' => 'exists:procedure_requirements,id',
        ]);

        $procedure->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'fee' => $request->fee,
            'estimated_days' => $request->estimated_days,
        ]);

        $procedure->requirements()->sync($request->requirements ?? []);

        return redirect()->route('admin.procedures.index')->with('success', 'Trámite actualizado con éxito.');
    }
}
