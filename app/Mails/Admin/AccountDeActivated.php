<?php

namespace App\Mails\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\EmailTemplate;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class AccountDeActivated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */

    public $user;

    /**
     * Create a new message instance.
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
        $emailTemplate = EmailTemplate::whereSlug('user-account-de-activated')->first(['subject', 'content']);

        $subject = $emailTemplate->subject;
        $content = $emailTemplate->content;

        $subject = str_replace('%APP_NAME%', config('app.name'), $subject);
        $content = str_replace('%USER_NAME%', $this->user->first_name, $content);
        $content = str_replace('%APP_NAME%', config('app.name'), $content);

        $this->subject($subject)
            ->view('emails.layout')
            ->with(['template' => $content]);
    }
}
