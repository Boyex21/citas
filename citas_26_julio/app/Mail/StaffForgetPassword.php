<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $staff;
    protected $template;
    public $subject;
    public function __construct($staff,$template,$subject)
    {
        $this->staff=$staff;
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
        $staff=$this->staff;
        return $this->subject($this->subject)->view('staff.staff_forget_pass_template',compact('staff','template'));
    }
}
