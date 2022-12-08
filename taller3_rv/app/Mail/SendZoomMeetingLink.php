<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendZoomMeetingLink extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $subject;
    public $template;
    public function __construct($subject,$template,$link)
    {
        $this->link=$link;
        $this->template=$template;
        $this->subject=$subject;
    }

    public function build()
    {
        $link=$this->link;
        $template=$this->template;
        return $this->subject($this->subject)->view('doctor.zoom_email',compact('template','link'));
    }
}
