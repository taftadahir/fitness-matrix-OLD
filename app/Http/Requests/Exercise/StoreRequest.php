<?php

namespace App\Http\Requests\Exercise;

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
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('exercises')->where('user_id', $this->user()->id)],
            'time_based' => ['bail', 'required', 'boolean'],
            'reps_based' => ['bail', 'required', 'boolean'],
            'published' => ['bail', 'required', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }
}
