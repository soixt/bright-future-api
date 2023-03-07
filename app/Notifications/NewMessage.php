<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;

    public $to, $from, $note, $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($to, $from, $note, $message)
    {
        $this->to = $to;
        $this->from = $from;
        $this->note = $note;
        $this->message = $message;
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
                    ->greeting('Dear ' . $this->to->name . ', ')
                    ->line('You got new message from ' . $this->from->name . '.')
                    ->line($this->note)
                    ->line('Message:')
                    ->line($this->message->body)
                    ->replyTo($this->from->email)
                    ->subject('New Message From ' . $this->from->name)
                    ->line('We hope that something good will happen!');
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
