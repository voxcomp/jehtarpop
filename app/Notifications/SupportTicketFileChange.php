<?php

namespace App\Notifications;

use App\Models\SupportTicketFile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportTicketFileChange extends Notification
{
    use Queueable;

    private $ticketfile;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SupportTicketFile $ticketfile)
    {
        $this->ticketfile = $ticketfile;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(config('app.name').' Support Ticket Update')
            ->greeting('Support Ticket Update!')
            ->line('There has been an update to the support ticket titled:')
            ->line($this->ticketfile->ticket->title)
            ->line('The uploaded file is '.strtoupper($this->ticketfile->original))
            ->action('View Support Ticket', route('support.detail', $this->ticketfile->ticket->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
