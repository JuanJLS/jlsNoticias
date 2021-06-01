<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeUserEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    private $enlace;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enlace)
    {
        $this->enlace = $enlace;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.changeuser')->subject('Cambio de Usuario')->with(['enlace' => $this->enlace]);
    }
}
