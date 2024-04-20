<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * ------------
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * ------------
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:tasks,name',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'project_id' => 'required|exists:projects,id',
        ];
    }
}
