<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\UserProcedure;
use App\Notifications\NewProcedureStartedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;

class ProcedureController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $procedures = Procedure::all();
        return view("procedures.index", compact("procedures"));
    }

    public function create()
    {
        $procedures = Procedure::all();
        return view("procedures.create", compact("procedures"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "procedure_id" => "required|exists:procedures,id",
        ]);

        $userProcedure = UserProcedure::create([
            "user_id" => Auth::id(),
            "procedure_id" => $validated["procedure_id"],
            "status" => "pending",
            "start_date" => now()->toDateString(),
        ]);

        // Notificar al administrador
        $admin = User::where("role", "admin")->first();
        if ($admin) {
            $admin->notify(new NewProcedureStartedNotification($userProcedure));
        }

        return redirect()->route("dashboard")->with("success", "Trámite iniciado correctamente.");
    }

    public function show(UserProcedure $userProcedure)
    {
        $this->authorize("view", $userProcedure);
        return view("procedures.show", compact("userProcedure"));
    }

    public function edit(UserProcedure $userProcedure)
    {
        $this->authorize("update", $userProcedure);
        $procedures = Procedure::all();
        return view("procedures.edit", compact("userProcedure", "procedures"));
    }

    public function update(Request $request, UserProcedure $userProcedure)
    {
        $this->authorize("update", $userProcedure);

        $validated = $request->validate([
            "procedure_id" => "required|exists:procedures,id",
            "status" => "required|in:pending,completed",
        ]);

        $userProcedure->update([
            "procedure_id" => $validated["procedure_id"],
            "status" => $validated["status"],
        ]);

        return redirect()->route("dashboard")->with("success", "Trámite actualizado correctamente.");
    }

    public function destroy(UserProcedure $userProcedure)
    {
        $this->authorize("delete", $userProcedure);
        $userProcedure->delete();
        return redirect()->route("dashboard")->with("success", "Trámite eliminado correctamente.");
    }
}
