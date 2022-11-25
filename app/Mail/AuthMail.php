<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthMail extends Mailable
{
    use Queueable, SerializesModels;
    public $verifyToken, $domain;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyToken, $domain)
    {
        $this->verifyToken = $verifyToken;
        $this->domain = $domain;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('auth', ['code' => $this->domain . '?token=' . $this->verifyToken]);
    }
}
