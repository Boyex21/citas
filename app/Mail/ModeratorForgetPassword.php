<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ModeratorForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $moderator;
    protected $template;
    public $subject;
    public function __construct($moderator,$template,$subject)
    {
        $this->moderator=$moderator;
        $this->subject=$subject;
        $this->template=$template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template=$this->template;
        $moderator=$this->moderator;
        return $this->subject($this->subject)->view('moderator.moderator_forget_pass_template',compact('moderator','template'));
    }
}
