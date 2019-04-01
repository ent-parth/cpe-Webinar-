<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EmailTemplate;
use CommonHelper;

class AdministratorResetPasswordToken extends Notification
{

    use Queueable;

    public $token;
    public $slug;
    public $administrator;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $slug, $administrator)
    {
        $this->token = $token;
        $this->slug = $slug;
        $this->administrator = $administrator;
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
            $replacementArr['USER_NAME'] = $this->administrator->full_name;
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
