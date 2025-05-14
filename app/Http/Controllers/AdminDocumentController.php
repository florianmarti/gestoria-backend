<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\UserProcedure;
use App\Notifications\DocumentStatusUpdatedNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminDocumentController extends Controller
{
    public function index()
    {
        $documents = Document::whereHas('userProcedure', function ($query) {
            $query->where('status', 'completed');
        })->get();

        return view('admin.documents.index', compact('documents'));
    }

    public function destroy(Document $document)
    {
        // Verificar que el trámite esté finalizado
        if ($document->userProcedure->status !== 'completed') {
            return redirect()->route('admin.documents.index')->with('error', 'Solo se pueden eliminar documentos de trámites finalizados.');
        }

        // Eliminar el archivo físico del almacenamiento
        if ($document->file_path && Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        // Eliminar el registro de la base de datos
        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Documento eliminado correctamente.');
    }
    public function approve(Document $document)
    {
        // Verificar que el trámite esté finalizado
        if ($document->userProcedure->status !== 'completed') {
            return redirect()->route('admin.documents.index')->with('error', 'Solo se pueden aprobar documentos de trámites finalizados.');
        }

        $document->update([
            'status' => Document::STATUS_APPROVED,
            'rejection_reason' => null,
        ]);

        // Notificar al usuario
        $user = $document->userProcedure->user;
        $user->notify(new DocumentStatusUpdatedNotification($document, 'aprobado'));

        return redirect()->route('admin.documents.index')->with('success', 'Documento aprobado correctamente.');
    }

    public function reject(Request $request, Document $document)
    {
        // Verificar que el trámite esté finalizado
        if ($document->userProcedure->status !== 'completed') {
            return redirect()->route('admin.documents.index')->with('error', 'Solo se pueden rechazar documentos de trámites finalizados.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $document->update([
            'status' => Document::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notificar al usuario
        $user = $document->userProcedure->user;
        $user->notify(new DocumentStatusUpdatedNotification($document, 'rechazado'));

        return redirect()->route('admin.documents.index')->with('success', 'Documento rechazado correctamente.');
    }
}
