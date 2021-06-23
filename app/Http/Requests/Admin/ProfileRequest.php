<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $id = Auth::guard('admin')->id();
        return [
            'first_name' => 'bail|required|max:50',
            'last_name' => 'bail|required|max:50',
            'email' => 'bail|required|email|max:100|unique:users,email,'.$id.',id',
            'phone' => 'bail|required|min:7|max:15||max:100|unique:users,phone,'.$id.',id',
            'photo' => 'bail|nullable|image'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo.image'=>'The photo must be an image.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'photo' => 'photo'
        ];
    }

}
