<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupporterCredential extends Mailable
{
    use Queueable, SerializesModels;


    public $supporter;
    public $password;
    public function __construct($supporter, $password)
    {
        $this->supporter = $supporter;
        $this->password = $password;
    }


    public function build()
    {
        $supporter = $this->supporter;
        $password = $this->password;
        return $this->subject('Supporter Credentials')->view('admin.supporter_credential', compact('supporter', 'password'));
    }
}
