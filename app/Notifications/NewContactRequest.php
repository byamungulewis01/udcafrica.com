<?php

namespace App\Notifications;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public ContactRequest $contactRequest)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Request Received')
            ->greeting('Hello!')
            ->line('A new contact request has been submitted.')
            ->line("From: {$this->contactRequest->name}")
            ->line("Email: {$this->contactRequest->email}")
            ->line("Phone: {$this->contactRequest->phone}")
            ->line("Message: {$this->contactRequest->message}")
            // ->action('View Request', route('contact-requests.index'))
            ->line('Thank you for using our application!');
    }
}
