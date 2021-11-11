<?php

namespace App\Http\Requests\Exercise;

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
        // $exercise = $this->exercise;
        // ->ignore($this->exercise->id)
        // ->where('user_id', $this->user()->id)
        // dd($this->exercise->id);
        return [
            'name' => ['nullable', 'string', 'max:255', Rule::unique('exercises', 'name')->where('user_id', $this->user()->id)->ignore($this->exercise->id)],
            'time_based' => ['nullable', 'boolean'],
            'reps_based' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }
}
