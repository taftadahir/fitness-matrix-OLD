<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'program_id' => $this->program_id,
            'name' => $this->name,
            'day' => $this->day,
            'set' => $this->set,
            'rest_time' => $this->rest_time,
            'warm_up_set' => $this->warm_up_set,
        ];
    }
}
