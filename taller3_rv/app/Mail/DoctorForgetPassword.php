<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $doctor;
    protected $template;
    public $subject;
    public function __construct($doctor,$template,$subject)
    {
        $this->doctor = $doctor;
        $this->subject = $subject;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template=$this->template;
        $doctor=$this->doctor;
        return $this->subject($this->subject)->view('doctor.doctor_forget_pass_template',compact('doctor','template'));
    }
}
