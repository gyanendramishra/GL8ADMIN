<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */

    public $user;

    /**
     * The token.
     *
     * @var Token
     */

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $et = EmailTemplate::whereName('Reset Password Mail')->first(['subject', 'body']);
        if($et){
            $subject = $et->subject;
            $body = $et->body;

            $body = str_replace('##USER_NAME##', $this->user->first_name, $body);
            $body = str_replace('##RESET_PASSWORD_LINK##', route('admin.password.reset', $this->token), $body);

            $this->subject($subject)
                ->view('emails.template')
                ->with(['template'=>$body]);
        }
    }
}
