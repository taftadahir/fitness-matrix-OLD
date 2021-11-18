<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserStatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'workout_id' => $this->workout_id,
            'reps' => $this->reps,
            'set' => $this->set,
            'time' => $this->time,
        ];
    }
}
