<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserStatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'workout_id' => ['bail', 'required', 'numeric', 'exists:workouts,id'],
            'reps' => ['nullable', 'numeric', 'min:0'],
            'time' => ['nullable', 'numeric', 'min:0'],
            'set' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
