<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'your-name' => 'required|string|min:3',
            'your-email' => 'required|email',
            'your-subject' => 'required|string|min:3',
            'your-message' => 'required|string|min:10'
        ];
    }
}
