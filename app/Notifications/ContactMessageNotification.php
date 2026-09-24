<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ContactMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Contact $contact
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    */

    public function via(object $notifiable): array
    {
        return [
            'database',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Database Notification
    |--------------------------------------------------------------------------
    */

    public function toDatabase(object $notifiable): array
    {
        return [

            'type' =>
                'contact_message',

            'contact_id' =>
                $this->contact->id,

            'title' =>
                'New Contact Message',

            'name' =>
                $this->contact->name,

            'email' =>
                $this->contact->email,

            'subject' =>
                $this->contact->subject,

            'inquiry_type' =>
                $this->contact->inquiry_type,

            'message' =>
                $this->contact->message,

            'status' =>
                $this->contact->status,

            'created_at' =>
                $this->contact->created_at?->toDateTimeString(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Array Notification
    |--------------------------------------------------------------------------
    */

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase(
            $notifiable
        );
    }
}