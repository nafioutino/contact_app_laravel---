<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactDeletedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Contact $contact)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Un contact a été supprimé.')
            ->action('Voir les contacts', url('/'))
            ->line('Merci d\'utiliser notre application!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Le contact {$this->contact->first_name} {$this->contact->last_name} a été supprimé avec succès.",
        ];
    }
}