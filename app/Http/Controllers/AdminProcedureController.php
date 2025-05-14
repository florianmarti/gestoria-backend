<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\ProcedureRequirement;
use App\Models\UserProcedure;
use App\Models\Document;
use Illuminate\Http\Request;

class AdminProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::orderBy('name', 'asc')->paginate(10);
        $userProcedures = UserProcedure::with(['user', 'procedure', 'documents'])
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(15);
        return view("admin.procedures.index", compact("procedures", "userProcedures"));
    }

    public function create()
    {
        $requirements = ProcedureRequirement::orderBy('name', 'asc')->get();
        return view("admin.procedures.create", compact("requirements"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255|unique:procedures,name",
            "category" => "required|in:Vehiculos,impositivo,otros",
            "fee" => "required|numeric|min:0",
            "estimated_days" => "required|integer|min:0",
            "description" => "nullable|string",
            "requirements" => "nullable|array",
            "requirements.*" => "exists:procedure_requirements,id"
        ]);

        $procedure = Procedure::create($validated);

        if ($request->has("requirements") && !empty($request->input("requirements"))) {
            $procedure->requirements()->attach($request->input("requirements"));
        }

        return redirect()->route("admin.procedures.index")->with("success", "Trámite creado correctamente.");
    }

    public function edit(Procedure $procedure)
    {
        $requirements = ProcedureRequirement::orderBy('name', 'asc')->get();
        $procedureRequirementsIds = $procedure->requirements()->pluck('procedure_requirements.id')->toArray();
        return view("admin.procedures.edit", compact("procedure", "requirements", "procedureRequirementsIds"));
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
        $procedure->requirements()->detach();
        $procedure->delete();
        return redirect()->route("admin.procedures.index")->with("success", "Trámite eliminado correctamente.");
    }

    public function complete(UserProcedure $userProcedure)
    {
        // Verificar si todos los documentos están aprobados
        $allApproved = $userProcedure->documents()->where('status', '!=', 'approved')->doesntExist();
        if (!$allApproved) {
            return redirect()->back()->with('error', 'No se puede completar el trámite hasta que todos los documentos estén aprobados.');
        }

        $userProcedure->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Trámite marcado como completado.');
    }

    public function documents(UserProcedure $userProcedure)
    {
        $documents = $userProcedure->documents()->with('requirement')->get();
        return view('admin.procedures.documents', compact('userProcedure', 'documents'));
    }

    public function approveDocument(UserProcedure $userProcedure, Document $document)
    {
        if ($document->user_procedure_id !== $userProcedure->id) {
            return redirect()->back()->with('error', 'El documento no pertenece a este trámite.');
        }

        $document->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Documento aprobado correctamente.');
    }
}
