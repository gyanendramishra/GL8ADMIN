<?php

use Symfony\Component\Yaml\Yaml;

/*
|--------------------------------------------------------------------------
| Site setings
|--------------------------------------------------------------------------
|
*/

if (file_exists(storage_path('app') . "/settings.yml")) {
    $settings = Yaml::parse(file_get_contents(storage_path('app') . "/settings.yml"));
    if (!empty($settings)) {
        return $settings;
    }
}

return [
    "app_name" => "GL8ADMIN",
    "business_email" => "admin@gl8admin.com",
    "business_phone" => "(91) 1234567890",
    "business_address" => "Jhalana institutional area",
    "from_email" => "noreply@gl8admin.com",
    "email_from_name" => "GL8ADMIN",
    "facebook_url" => null,
    "twitter_url" => null,
    "linkedin_url" => null,
    "youtube_url" => null,
    "logo" => "",
    "favicon" => "",
];
