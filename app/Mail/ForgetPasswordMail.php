<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    /**
     * Create a new message instance.
     *
     * @var User
     *
     * @return void
     */
    public function __construct(User $user)
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
        return $this->markdown('emails.forgetpassword')->with([
            'forget_code' => $this->user->forget_code,
            'url' => getenv('APP_URL_FRONT').'/reset-password/'.'?forget_code='.$this->user->forget_code,
        ]);
    }
}
