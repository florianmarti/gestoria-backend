<?php

namespace App\Http\Controllers;

use App\Models\UserProcedure;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión para ver las notificaciones.');
        }

        $admin = Auth::user();
        if (!$admin instanceof \App\Models\User) {
            return redirect()->route('login')->with('error', 'Usuario no válido.');
        }

        $notifications = $admin->notifications()->get();

        $filteredNotifications = $notifications->filter(function ($notification) {
            if ($notification->type === \App\Notifications\NewProcedureStartedNotification::class) {
                $userProcedureId = $notification->data['user_procedure_id'] ?? null;
                return $userProcedureId && UserProcedure::find($userProcedureId);
            }
            return true;
        });

        return view('admin.notifications.index', compact('filteredNotifications'));
    }
}
