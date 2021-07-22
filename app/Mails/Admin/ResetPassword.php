<?php

namespace App\Mails\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\EmailTemplate;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
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
        $emailTemplate = EmailTemplate::whereSlug('admin-password-reset')->first(['subject', 'content']);

        $subject = $emailTemplate->subject;
        $content = $emailTemplate->content;

        $subject = str_replace('%APP_NAME%', config('app.name'), $subject);
        $content = str_replace('%USER_NAME%', $this->user->first_name, $content);
        $content = str_replace('%RESET_PASSWORD_LINK%', route('admin.password.reset', $this->token), $content);
        $content = str_replace('%APP_NAME%', config('app.name'), $content);

        $this->subject($subject)
            ->view('emails.layout')
            ->with([ 'template'=> $content ]);
    }
}
