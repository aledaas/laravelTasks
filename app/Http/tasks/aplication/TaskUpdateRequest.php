<?php

namespace App\Http\tasks\aplication;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
            'priority' => ['required'],
            'assigner' => ['required'],
            'tags' => ['required'],
            'description' => ['required'],
            'due_date' => ['required'],
            'status' => ['required','IN:Todo,Doing,Blocked,Done']
        ];
    }
}
