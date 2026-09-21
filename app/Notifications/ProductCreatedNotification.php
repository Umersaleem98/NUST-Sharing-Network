<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductCreatedNotification extends Notification
{
    use Queueable;

    public Product $product;

    /**
     * Create notification.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Notification channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }

    /**
     * Email notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Product Added - NUST Sharing Network')
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line(
                'A new product has been added to the NUST Sharing Network.'
            )
            ->line(
                'Product: ' . $this->product->name
            )
            ->action(
                'View Product',
                url('/products/' . $this->product->id)
            )
            ->line(
                'Thank you for using the NUST Sharing Network.'
            );
    }

    /**
     * Database notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,

            'name' => $this->product->name,

            'message' =>
                'A new product has been added: '
                . $this->product->name,
        ];
    }
}