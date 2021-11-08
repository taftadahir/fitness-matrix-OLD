<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('programs')->where('user_id', $this->user()->id)],
            'days' => ['bail', 'required', 'integer', 'min:0'],
            'use_warm_up' => ['bail', 'required', 'boolean'],
            'use_program_set' => ['bail', 'required', 'boolean'],
            'use_workout_set' => ['bail', 'required', 'boolean'],
            'published' => ['bail', 'required', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }
}
