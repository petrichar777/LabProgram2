<?php

<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> 0015bfb2bb49bf44b98d4527abea4ffd161c1eaf
=======

>>>>>>> d6f3464 (first commit)
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
<<<<<<< HEAD
<<<<<<< HEAD
        return $this->view('verification')
            ->with([
                'verificationCode' => $this->code,
            ]);
=======
        return $this->view('emails.verification');
>>>>>>> 0015bfb2bb49bf44b98d4527abea4ffd161c1eaf
=======
        return $this->view('emails.verification')
            ->with([
                'code'=>$this->code,
            ]);
>>>>>>> d6f3464 (first commit)
    }
}
