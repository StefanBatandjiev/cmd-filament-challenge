<?php

namespace App\Notifications;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuoteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Quote $quote)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Quote Submitted')
            ->line('A new quote has been submitted:')
            ->line("Name: {$this->quote->name}")
            ->line("Email: {$this->quote->email}")
            ->line("Phone: {$this->quote->phone}")
            ->line("Service: {$this->quote->service->getLabel()}")
            ->line("Booking: {$this->quote->booked_at->format('Y-m-d H:i')}")
            ->line("Duration: {$this->quote->duration} hour(s)")
            ->lineIf($this->quote->notes, 'Notes: ' . $this->quote->notes);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
