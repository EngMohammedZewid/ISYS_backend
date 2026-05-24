<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    protected string $emailCode;

    /**
     * Create a new message instance.
     *
     * @var User
     *
     * @return void
     */
    public function __construct(User $user, string $emailCode)
    {
        $this->user = $user;
        $this->emailCode = $emailCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emailverification')->with([
            'emailCode' => $this->user->email_code,
        ]);
    }
}
