<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
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
        $id = $this->id;

        switch ($this->method()) {
            case 'GET': {
                    return [];
                }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'first_name' => 'bail|required|string|max:50',
                        'last_name' => 'bail|required|string|max:50',
                        'email' => 'bail|required|email|max:100|unique:users,email',
                        'phone' => 'bail|required|min:7|max:15|unique:users,phone',
                        'role' => 'bail|required',
                        'photo' => 'bail|nullable|image'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'first_name' => 'bail|required|string|max:50',
                        'last_name' => 'bail|required|string|max:50',
                        'email' => 'bail|required|email|max:100|unique:users,email,' . $id . ',id',
                        'phone' => 'bail|required|min:7|max:15||max:100|unique:users,phone,' . $id . ',id',
                        'role' => 'bail|required',
                        'photo' => 'bail|nullable|image'
                    ];
                }
            default:
                break;
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('photo')) {
                if ($this->file('photo')->getSize() > '5242880') {
                    $validator->errors()->add('photo', 'Photo shouldn\'t be greater than 5 MB. Please select another photo.');
                }
            }
        });
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo.image' => 'The photo must be an image.',
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
