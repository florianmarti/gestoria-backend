<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\UserProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;

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
         // Verificar autorización
         $this->authorize('view', $userProcedure);

         // Validación de entrada
         $validated = $request->validate([
             'requirement_id' => 'required|exists:procedure_requirements,id',
             'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
         ]);

         try {
             // Obtener el requisito relacionado
             $requirement = $userProcedure->procedure->requirements()
                 ->findOrFail($validated['requirement_id']);

             // Verificar que el requisito acepte archivos
             if ($requirement->type !== 'file') {
                 return response()->json([
                     'success' => false,
                     'message' => 'El requisito seleccionado no acepta archivos',
                 ], 422);
             }

             $file = $request->file('file');

             // Generar nombre único para el archivo
             $fileName = $this->generateUniqueFileName($file);
             $storagePath = "procedures/{$userProcedure->id}/documents";

             // Almacenar el archivo
             $path = $file->storeAs($storagePath, $fileName, 'public');

             // Crear registro en la base de datos
             $document = Document::updateOrCreate(
                 [
                     'user_procedure_id' => $userProcedure->id,
                     'procedure_requirement_id' => $requirement->id
                 ],
                 [
                     'file_path' => $path,
                     'status' => 'pending'
                 ]
             );

             // Respuesta exitosa
             return response()->json([
                 'success' => true,
                 'message' => 'Archivo subido correctamente',
                 'document' => $document,
                 'file_url' => Storage::url($path),
                 'file_name' => $file->getClientOriginalName(),
                 'file_size' => $file->getSize(),
                 'file_type' => $file->getMimeType(),
                 'requirement_name' => $requirement->name
             ]);

         } catch (\Exception $e) {
             // Limpieza en caso de error
             if (isset($path) && Storage::disk('public')->exists($path)) {
                 Storage::disk('public')->delete($path);
             }

             // Respuesta de error
             return response()->json([
                 'success' => false,
                 'message' => 'Error al procesar el archivo',
                 'error' => config('app.debug') ? $e->getMessage() : null,
                 'file' => $request->file('file') ? $request->file('file')->getClientOriginalName() : null
             ], 500);
         }
     }

     /**
      * Genera un nombre único para el archivo
      */
     private function generateUniqueFileName($file)
     {
         return Str::uuid() . '.' . $file->getClientOriginalExtension();
     }
}
