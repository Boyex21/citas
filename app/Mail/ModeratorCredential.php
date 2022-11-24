<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ModeratorCredential extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $moderator;
    public $password;
    public function __construct($moderator, $password)
    {
        $this->moderator = $moderator;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $moderator = $this->moderator;
        $password = $this->password;
        return $this->subject('Moderator Credentials')->view('admin.moderator_credential', compact('moderator', 'password'));
    }
}
