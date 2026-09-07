<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ContactMessageNotification extends Notification
{
    use Queueable;

    protected Contact $contact;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Notification delivery channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
        ];
    }

    /**
     * Database notification data.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,

            'title' => 'New Contact Message',

            'message' =>
                $this->contact->name .
                ' sent a new contact message.',

            'sender_name' =>
                $this->contact->name,

            'sender_email' =>
                $this->contact->email,

            'subject' =>
                $this->contact->subject,

            'inquiry_type' =>
                $this->contact->inquiry_type,

            'url' => route(
                'admin.contact.show',
                $this->contact->id
            ),

            'icon' => 'fa-solid fa-envelope-open-text',
        ];
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}