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
        return view("admin.procedures.index", compact("procedures"));
    }

    public function create()
    {
        $requirements = ProcedureRequirement::all();
        return view("admin.procedures.create", compact("requirements"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "category" => "required|in:Vehiculos,impositivo,otros",
            "fee" => "required|numeric",
            "estimated_days" => "required|integer",
            "description" => "nullable|string",
            "requirements" => "array",
        ]);

        $procedure = Procedure::create($validated);

        if ($request->has("requirements")) {
            $procedure->requirements()->attach($request->input("requirements"));
        }

        return redirect()->route("admin.procedures.index")->with("success", "Trámite creado correctamente.");
    }

    public function edit(Procedure $procedure)
    {
        $requirements = ProcedureRequirement::all();
        return view("admin.procedures.edit", compact("procedure", "requirements"));
    }

    public function update(Request $request, Procedure $procedure)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "category" => "required|in:Vehiculos,impositivo,otros",
            "fee" => "required|numeric",
            "estimated_days" => "required|integer",
            "description" => "nullable|string",
            "requirements" => "array",
        ]);

        $procedure->update($validated);

        if ($request->has("requirements")) {
            $procedure->requirements()->sync($request->input("requirements"));
        }

        return redirect()->route("admin.procedures.index")->with("success", "Trámite actualizado correctamente.");
    }
    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
        return redirect()->route("admin.procedures.index")->with("success", "Trámite eliminado correctamente.");
    }
}
