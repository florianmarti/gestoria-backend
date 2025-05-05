<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentUploadedNotification extends Notification
{
    use Queueable;

    protected $document;

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function via($notifiable)
    {
        return ["database"];
    }

    public function toArray($notifiable)
    {
        return [
            "message" => "El usuario " . $this->document->userProcedure->user->name . " ha subido un documento para el trámite: " . $this->document->userProcedure->procedure->name,
            "document_id" => $this->document->id,
            "user_procedure_id" => $this->document->userProcedure->id,
        ];
    }
}
