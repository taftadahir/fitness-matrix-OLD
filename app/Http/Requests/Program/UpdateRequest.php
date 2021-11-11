<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255', Rule::unique('programs')->where('user_id', $this->user()->id)->ignore($this->program->id)],
            'days' => ['nullable', 'integer', 'min:0'],
            'use_warm_up' => ['nullable', 'boolean'],
            'use_program_set' => ['nullable', 'boolean'],
            'use_workout_set' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }
}
