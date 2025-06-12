<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $verifyUrl;

    public function __construct($otp, $verifyUrl)
    {
        $this->otp = $otp;
        $this->verifyUrl = $verifyUrl;
    }

    public function build()
    {
        return $this->subject('KhetiBook OTP Verification')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'verifyUrl' => $this->verifyUrl,
                    ]);
    }
}
