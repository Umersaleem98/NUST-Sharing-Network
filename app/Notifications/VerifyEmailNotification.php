<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(
        object $notifiable
    ): MailMessage {
        /*
        |--------------------------------------------------------------------------
        | Verification URL
        |--------------------------------------------------------------------------
        */

        $verificationUrl = route(
            'verification.verify',
            [
                'user' => $notifiable->id,
                'token' => $this->token,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        $logoUrl = asset(
            'admins/images/logo.png'
        );


        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        return (new MailMessage)
            ->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->subject(
                'Verify Your Email Address | NUST Sharing Network'
            )
            ->view(
                'pages.auth.email.verify-email',
                [
                    'user' =>
                        $notifiable,

                    'verificationUrl' =>
                        $verificationUrl,

                    'logoUrl' =>
                        $logoUrl,
                ]
            );
    }
}