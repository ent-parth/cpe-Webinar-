<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommonMail extends Mailable
{

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailContent, $subject)
    {
        $this->emailContent = $emailContent;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return mail with an attachment
        return $this->view('backEnd.emails.commenEmail')
                        ->subject($this->subject)
                        ->with(['emailContent' => $this->emailContent]);
    }
}
