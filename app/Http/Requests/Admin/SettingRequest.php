<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_name' => 'bail|required|max:100',
            'business_email' => 'bail|nullable|email|max:100',
            'business_phone' => 'bail|nullable|max:100',
            'business_address' => 'bail|nullable|max:100',
            'from_email' => 'bail|required|email|max:100',
            'email_from_name' => 'bail|required|max:100',
            'facebook_url' => 'bail|nullable|url|max:100',
            'twitter_url' => 'bail|nullable|url|max:100',
            'linkedin_url' => 'bail|nullable|url|max:100',
            'youtube_url' => 'bail|nullable|url|max:100',
            'logo' => 'bail|nullable|image',
            'favicon' => 'bail|nullable|image',
        ];
    }

}
