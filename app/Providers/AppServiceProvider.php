<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifica tu dirección de correo')
                ->line('Haz clic en el botón de abajo para verificar tu dirección de correo.')
                ->action('Verificar Correo', $url)
                ->line('Si no creaste una cuenta, no es necesario que hagas nada.');
        });
    }
}
