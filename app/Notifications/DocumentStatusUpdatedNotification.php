<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $document;
    protected $action;

    public function __construct($document, $action)
    {
        $this->document = $document;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $requirementName = $this->document->requirement ? $this->document->requirement->name : 'Requisito desconocido';
           return [
               'document_id' => $this->document->id,
               'action' => $this->action,
               'message' => "Tu documento relacionado con el requisito '{$requirementName}' ha sido {$this->action}.",
               'rejection_reason' => $this->document->rejection_reason,
           ];
    }
}
