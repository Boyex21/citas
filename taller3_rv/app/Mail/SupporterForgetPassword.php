<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupporterForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $supporter;
    protected $template;
    public $subject;
    public function __construct($supporter,$template,$subject)
    {
        $this->supporter=$supporter;
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
        $supporter=$this->supporter;
        return $this->subject($this->subject)->view('supporter.supporter_forget_pass_template',compact('supporter','template'));
    }
}
