<?php

use App\Models\Faq;
use App\Models\Role;
use App\Models\User;
use App\Models\Page;
use App\Models\Enquiry;
use App\Models\Setting;
use App\Models\EmailHook;
use App\Models\EmailLayout;
use App\Models\EmailTemplate;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        factory(Role::class)->create(['name' => 'Admin']);
        factory(Role::class)->create(['name' => 'User']);

        // Create super admin user
        factory(User::class)->create([
            'first_name' => 'Gyanendra',
            'last_name' => 'Mishra',
            'email' => 'gyanendra.kumar@dotsquares.com'
        ])->each(function ($user) {
            $user->roles()->attach(1);
        });

        // Create system user
        factory(User::class, 100)->create()->each(function ($user) {
            $user->roles()->attach(2);
        });

        // Create inquiries
        factory(Enquiry::class, 100)->create();

        // Create faq
        factory(Faq::class, 20)->create();

        // Create page
        factory(Page::class, 5)->create();

        // Create email hook
        $emailHook = factory(EmailHook::class)->create([
            'name' => 'Reset Password Notification',
            'slug' => Str::slug('reset password notification', '-')
        ]);

        // Create email layout
        $emailLayout = factory(EmailLayout::class)->create([
            'name' => 'Default',
            'content' => '<table>
                <tr><td>##TEMPLATE##</td></tr>
            </table>',
            'slug' => Str::slug('default', '-')
        ]);

        // Create email template
        factory(EmailTemplate::class)->create([
            'email_hook_id' => $emailHook->id,
            'email_layout_id' => $emailLayout->id,
            'subject' => 'Reset Password Notification',
            'content' => '<p>You are receiving this email because we received a password reset request for your account.</p>
                            <a href="##actionUrl##">##actionText##</a>
                            <p>This password reset link will expire in ##EXPIRE_IN## minutes.</p>
                            <p>If you’re having trouble clicking the ##actionText## button, copy and paste the URL below into your web browser: ##actionUrl##</p>
                            <p>If you did not request a password reset, no further action is required.</p>
                        '
        ]);

        // Create settings
        Setting::insert([
            ['key' => 'app_name', 'value' => 'Demo App'],
            ['key' => 'business_email', 'value' => 'demo@example.com'],
            ['key' => 'business_phone', 'value' => '(91) 1234567890'],
            ['key' => 'business_address', 'value' => 'Jhalana institutional area'],
            ['key' => 'from_email', 'value' => 'demo@example.com'],
            ['key' => 'email_from_name', 'value' => 'Demo'],
            ['key' => 'email_from_name', 'value' => 'Demo'],
            ['key' => 'facebook_url', 'value' => ''],
            ['key' => 'twitter_url', 'value' => ''],
            ['key' => 'linkedin_url', 'value' => ''],
            ['key' => 'youtube_url', 'value' => ''],
            ['key' => 'logo', 'value' => ''],
            ['key' => 'favicon', 'value' => '']
        ]);

    }
}
