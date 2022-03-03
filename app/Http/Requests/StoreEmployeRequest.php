<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
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
            'email' => 'required|unique:employes,email',
            'phone_number' => 'required',
            'password' => 'required',
            'address' => 'nullable|max:200',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'profile_picture' => 'nullable'
        ];
    }
}
