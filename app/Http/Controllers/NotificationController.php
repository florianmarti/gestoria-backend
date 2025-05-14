<?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use App\Models\User;

   class NotificationController extends Controller
   {
       public function index()
       {
           /** @var User $user */
           $user = Auth::user();
           $notifications = $user->unreadNotifications()->paginate(10);
           return view('notifications.index', compact('notifications'));
       }

       public function read($id)
       {
           /** @var User $user */
           $user = Auth::user();
           $notification = $user->notifications()->findOrFail($id);
           $notification->markAsRead();
           return redirect()->back()->with('success', 'Notificación marcada como leída.');
       }
   }
