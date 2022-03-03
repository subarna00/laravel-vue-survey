<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeRequest extends FormRequest
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
            'name' => 'required|max:100',
            'user_id' => 'exists:users,id',
            'phone_number' => 'required',
            'password' => 'required',
            'address' => 'nullable|max:200',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'profile_picture' => 'nullable'
        ];
    }
}
