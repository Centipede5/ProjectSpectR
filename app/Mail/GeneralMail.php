<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $to;
    public $subject;
    public $data;
    public $userId;
    public $template;
    public $scheduled;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $data, $userId, $template, $scheduled)
    {
        $this->to = $to;
//        $this->subject;
//        $this->data;
//        $this->userId;
//        $this->template;
//        $this->scheduled;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.general-email');
    }
}
