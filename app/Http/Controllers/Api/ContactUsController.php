<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactUsController extends Controller
{
    use Queueable;
    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    /**
     * Tag List
     * 
     * @param Request $request
     * @return type
     */
    public function index()
    {
        try {
            $contactUs = \App\Models\Subject::select('id', 'subject')->active()->get()->toArray();
            return $this->APIResponse->respondWithMessageAndPayload([
                            'subject' => !empty($contactUs) ? $contactUs : []]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Contact US
     * 
     * @param Request $request
     * @return type
     */
    public function contactUs(Request $request)
    {
        try {
            //get email template.
            //$emailTemplate = EmailTemplate::where('slug', $this->slug)->first();
            $template_text = '<div class="confirmation-main">
                <section class="page-detail-box">
                <div class="container">
                <div class="content-detail-box">
                <h2>Hello,</h2>

                <h3>Name: {NAME}</h3>

                <h3>Contact Number: {CONTACT_NUMBER}</h3>

                <h3>Email: {EMAIL}</h3>

                <h3>Message: {MESSAGE}</h3>

                </div>
                </section>
                </div>';
            if (!empty($template_text)) {
                $replacementArr['NAME'] = $request->name;
                $replacementArr['CONTACT_NUMBER'] = $request->contact_number;
                $replacementArr['EMAIL'] = $request->email;
                $replacementArr['MESSAGE'] = $request->message;
                $emailContent = $this->replaceEmailContent($template_text, $replacementArr);
                //echo $emailContent;exit;

                /*Mail::send('user.emails.send-password', $replacementArr , function ($message) use ($mailData){
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($mailData['to']);
                    $message->subject($mailData['subject']);
                });*/
                //(new MailMessage)->subject($request->subject)->view('backEnd.emails.commenEmail', ['emailContent' => $emailContent]);
            }
            return $this->APIResponse->respondWithMessage(__('Message send successfully'));
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    public function replaceEmailContent($content = "", $valueArr = [])
    {
        //echo $content;exit;
        if ($content != "" && count($valueArr) > 0) {
            foreach ($valueArr as $key => $value) {
                $content = str_replace('{' . $key . '}', $value, $content);
            }

            return $content;
        } else {
            return $content;
        }
    }
}
