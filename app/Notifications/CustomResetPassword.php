<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends BaseResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notificação de Redefinição de Senha')
            ->greeting('Olá!')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para a sua conta.')
            ->action('Redefinir Senha', url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('Este link para redefinição de senha expirará em 60 minutos.')
            ->line('Se você não solicitou a redefinição de senha, nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Equipe IPoop');
    }
}
