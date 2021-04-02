<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\User;

class NewAccount extends Notification
{
    use Queueable;
    public $user ;
    private $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user ;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $this->user ;
        return (new MailMessage)
                    ->greeting("Bonjour $user->prenom $user->name")
                    ->line("Bienvenu sur l'Agenda du Québec.")
                    ->line("Votre compte a été parfaitement configuré.")
                    ->line("Vous pouvez vous connecter avec les accès suivants.")
                    ->line("Votre login : $user->email")
                    ->line("Votre mot de passe : ".$this->password)
                    ->line("")
                    ->line("Vous pouvez toujours modifier votre mot de passe dans votre profil.")
                    ->action("Retourner sur le site Web", url('/'))
                    ->line('Merci et à toute!')
                    ->subject("Votre compte l'Agenda du Quebec!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
