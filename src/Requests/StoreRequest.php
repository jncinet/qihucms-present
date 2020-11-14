<?php

namespace Qihucms\Present\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *sometimes
     * @return array
     */
    public function rules()
    {
        return [
            'present_id' => ['required', 'exists:presents,id'],
            'to_user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function attributes()
    {
        return trans('present::order');
    }
}