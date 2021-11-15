<?php

namespace App\Http\Requests\Workout;

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
        $prevable_type = $this->request->get('prevable_type');
        $prev_id_rules = Rule::exists($prevable_type . 's', 'id');
        return [
            'prevable_id' => ['nullable', 'numeric', 'required_with:prevable_type', $prevable_type ? $prev_id_rules : ''],
            'prevable_type' => ['nullable', 'string', 'max:255'],
            'exercise_id' => ['bail', 'required', 'numeric', 'exists:exercises,id'],
            'program_id' => ['bail', 'required', 'numeric', 'exists:programs,id'],
            'day' => ['nullable', 'numeric', 'min:0'],
            'reps_based' => ['nullable', 'boolean'],
            'reps' => ['nullable', 'numeric', 'min:0'],
            'time_based' => ['nullable', 'boolean'],
            'time' => ['nullable', 'numeric', 'min:0'],
            'set' => ['nullable', 'numeric', 'min:0'],
            'rest_time' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
