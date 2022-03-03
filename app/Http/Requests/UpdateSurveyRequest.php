<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $survey = $this->route('survey');
        if ($this->user()->id !== $survey->user_id) {
            return false;
        }
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
            'title' => 'required|string|max:1000',
            'user_id' => 'exists:users,id',
            'image' => 'nullable|string',
            'status' => 'required|boolean',
            'descripiton' => 'nullable|string',
            'client_id' => 'required',
            'employe_id' => 'required',
            'expire_data' => 'nullable|date|tomorrow',
            'questions' => 'array'
        ];
    }
}
