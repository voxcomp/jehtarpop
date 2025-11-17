<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\SupportTicketNote;

class SupportTicketNoteChange extends Notification
{
    use Queueable;
    private $note;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SupportTicketNote $note)
      {
          $this->note=$note;
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
         return (new MailMessage)
            ->subject(config('app.name').' Support Ticket Update')
            ->greeting('Support Ticket Update!')
            ->line('There has been an update to the support ticket titled:')
            ->line($this->note->ticket->title)
            ->line('A new note has been added: '.$this->note->description)
            ->action('View Support Ticket', route('support.detail',$this->note->ticket->id));
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
