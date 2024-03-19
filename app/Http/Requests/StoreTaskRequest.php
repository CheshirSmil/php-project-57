<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:tasks', 'max:255'],
            'description' => 'max:500',
            'status_id' => 'required',
            'assigned_to_id' => ['nullable', 'exists:users,id'],
            'labels' => ['nullable', 'array'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => __('layout.form.task_unique'),
            'name.required' => __('layout.form.task_required'),
            'status_id.required' => __('layout.form.task_status_required'),
            'name.max' => __('layout.form.name_max'),
            'description.max' => __('layout.form.description_max'),
        ];
    }
}
