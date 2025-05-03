<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\UserProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProcedureController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $procedures = Procedure::all();
        return view('procedures.index', compact('procedures'));
    }

    public function create()
    {
        $procedures = Procedure::all();
        return view('procedures.create', compact('procedures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
        ]);

        $userProcedure = UserProcedure::create([
            'user_id' => Auth::id(),
            'procedure_id' => $request->procedure_id,
            'status' => 'pending',
            'start_date' => now(),
        ]);

        return redirect()->route('procedures.show', $userProcedure)->with('success', 'Trámite iniciado con éxito.');
    }

    public function show(UserProcedure $userProcedure)
    {
        $this->authorize('view', $userProcedure);
        return view('procedures.show', compact('userProcedure'));
    }
}
