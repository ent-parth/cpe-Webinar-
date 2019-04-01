<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EmailTemplate;
use CommonHelper;

class SpeakerResetPasswordToken extends Notification
{

    use Queueable;

    public $token;
    public $slug;
    public $company;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $slug, $company)
    {
        $this->token = $token;
        $this->slug = $slug;
        $this->company = $company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //get email template.
        $emailTemplate = EmailTemplate::where('slug', $this->slug)->first();
        if (!empty($emailTemplate)) {
            $replacementArr['USER_NAME'] = $this->company->full_name;
            $replacementArr['URL'] = url('/reset', $this->token);
            $emailContent = CommonHelper::replaceEmailContent($emailTemplate->template_text, $replacementArr);

            return (new MailMessage)->subject($emailTemplate->subject)->view('backEnd.emails.commenEmail', ['emailContent' => $emailContent]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
        ];
    }
}
