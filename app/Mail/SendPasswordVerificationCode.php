<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPasswordVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;

    public function __construct($user)
    {
    
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $code = random_int(100000, 999999);
        $this->user->verification_code = $code;
        $this->user->save();

        return $this->from(config('email.from.address'), config('email.from.name'))
                ->markdown('emails.password.send_verification_code')
                ->subject(config('email.password_verification_code'))
                ->with([
                    'code' => $code,
                ]);
    }
}
