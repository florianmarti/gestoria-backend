<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewProcedureStartedNotification extends Notification
{
    use Queueable;

    protected $userProcedure;

    public function __construct($userProcedure)
    {
        $this->userProcedure = $userProcedure;
    }

    public function via($notifiable)
    {
        return ["database"];
    }

    public function toArray($notifiable)
    {
        return [
            "message" => "El usuario " . $this->userProcedure->user->name . " ha iniciado un nuevo trámite: " . $this->userProcedure->procedure->name,
            "user_procedure_id" => $this->userProcedure->id,
        ];
    }
}
