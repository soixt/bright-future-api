<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailgun extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $template = 'welcome')
    {
        $this->user = $user;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.' . $this->template);
    }
}
