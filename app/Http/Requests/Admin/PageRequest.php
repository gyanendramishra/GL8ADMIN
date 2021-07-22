<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class PageRequest extends FormRequest
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

        return [
            'title' => 'bail|required|string|max:100|unique:pages,title,' . $id . ',id',
            'excerpt' => 'bail|required|string|max:1000',
            'content' => 'bail|string|required',
            'meta_title' => 'bail|nullable|string|max:100',
            'meta_keyword' => 'bail|nullable|string|max:100',
            'meta_description' => 'bail|nullable|string|max:100',
        ];
    }
}
