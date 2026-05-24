<?php

namespace App\Mail;

use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUSMail extends Mailable
{
    use Queueable, SerializesModels;

    protected ContactUs $conactUs;

    /**
     * Create a new message instance.
     *
     * @var User
     *
     * @return void
     */
    public function __construct(ContactUs $conactUs)
    {
        $this->conactUs = $conactUs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emailcontactus')->with([
            'companyName' => $this->conactUs->company_name,
        ]);
    }
}
