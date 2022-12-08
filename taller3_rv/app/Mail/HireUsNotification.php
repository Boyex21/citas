<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HireUsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $template;
    public $subject;
    public function __construct($template,$subject)
    {
        $this->template=$template;
        $this->subject=$subject;
    }

    public function build()
    {
        $template = $this->template;
        return $this->subject($this->subject)->view('hire_us_email_template', compact('template'));
    }
}