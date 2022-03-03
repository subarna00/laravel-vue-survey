<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
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
            'title' => 'required|string|max:1000',
            'user_id' => 'exists:users,id',
            'client_id' => 'required',
            'employe_id' => 'required',
            'image' => 'nullable|string',
            'status' => 'required|boolean',
            'descripiton' => 'nullable|string',
            'expire_data' => 'nullable|date|tomorrow',
            'questions' => 'array'
        ];
    }
}
