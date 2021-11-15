<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'exercise_id' => $this->exercise_id,
            'program_id' => $this->program_id,
            'day' => $this->day,
            'reps_based' => $this->reps_based,
            'reps' => $this->reps,
            'time_based' => $this->time_based,
            'time' => $this->time,
            'set' => $this->set,
            'rest_time' => $this->rest_time,
        ];
    }
}
