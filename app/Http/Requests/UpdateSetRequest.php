<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSetRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'program_id' => ['nullable', 'numeric', 'exists:programs,id'],
            'day' => ['nullable', 'numeric', 'min:0'],
            'set' => ['nullable', 'numeric', 'min:0'],
            'rest_time' => ['nullable', 'numeric', 'min:0'],
            'warm_up_set' => ['nullable', 'boolean'],
        ];
    }
}
