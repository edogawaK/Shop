<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuiEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $flag;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($flag=false)
    {
        $this->flag=$flag;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('shoii.sgu@gmail.com', 'Shoii')
            ->to('kisenguyen1410263@gmail.com')
            ->subject('NKKN')
            ->view('auth',['code'=>1234]);
    }
}
