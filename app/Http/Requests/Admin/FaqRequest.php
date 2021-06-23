<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class FaqRequest extends FormRequest
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
            case 'GET':{
                return [];
            }
            case 'DELETE': {
                    return [];
            }
            case 'POST': {
                return [
                    'title' => 'bail|required|max:100|unique:faqs,title',
                    'description' => 'bail|required|max:1000',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'title' => 'bail|required|max:100|unique:faqs,title,'.$id.',id',
                    'description' => 'bail|required|max:1000',
                ];
            }
            default:break;
        }
    }

}
