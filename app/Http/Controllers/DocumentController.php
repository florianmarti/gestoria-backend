<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\UserProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function create(UserProcedure $userProcedure)
    {
        $this->authorize("update", $userProcedure);

        // Cargar los requisitos asociados al trámite
        $requirements = $userProcedure->procedure->requirements;
        // dd($requirements);
        return view("documents.create", compact("userProcedure", "requirements"));
    }

    public function store(Request $request, UserProcedure $userProcedure)
    {
        $this->authorize("update", $userProcedure);

        $validated = $request->validate([
            "requirement_id" => "required|exists:procedure_requirements,id",
            "file" => "required|file|mimes:jpg,png,pdf|max:2048",
        ]);

        $files = $request->file("file");

        $uploadedFiles = [];

        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $path = $file->store("documents", "public");
                $document = Document::create([
                    "user_procedure_id" => $userProcedure->id,
                    "procedure_requirement_id" => $validated["requirement_id"],
                    "file_path" => $path,
                    "status" => "pending",
                ]);
                $uploadedFiles[] = $document;
            }
        } elseif ($files instanceof \Illuminate\Http\UploadedFile) {
            $path = $files->store("documents", "public");
            $document = Document::create([
                "user_procedure_id" => $userProcedure->id,
                "procedure_requirement_id" => $validated["requirement_id"],
                "file_path" => $path,
                "status" => "pending",
            ]);
            $uploadedFiles[] = $document;
        }

        return redirect()->route("procedures.show", $userProcedure)->with("success", "Documento(s) subido(s) correctamente.");
        dd(session()->all());
    }
}
