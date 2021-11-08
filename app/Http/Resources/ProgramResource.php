<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'days' => $this->days,
            'use_warm_up' => $this->use_warm_up,
            'use_program_set' => $this->use_program_set,
            'use_workout_set' => $this->use_workout_set,
            'published' => $this->published,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
