<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RedefinirSenhaNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email, $name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $minutos = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
        $url = 'http://localhost:8000/password/reset/' . $this->token . '?email=' . $this->email;

        return (new MailMessage)
            ->subject('Atualização de senha')
            ->greeting('Olá, ' . $this->name . '!')
            ->line('Esqueceu a senha? Sem problemas! Vamos resolver isso!')
            ->action(('Redefinir senha'), $url)
            ->line('O link acima expira em ' . $minutos . ' minutos.')
            ->line('Caso não tenha requisitado alteração de senha, apenas ignore esse e-mail')
            ->salutation('Até breve,');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
