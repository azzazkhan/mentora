<?php

namespace Modules\Classroom\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Classroom\Enums\Status;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,

            'icon' => $this->icon,
            'cover' => $this->cover,
            'color' => $this->color,

            $this->mergeWhen($this->pending || $this->registrationOpen, [
                'registration_start_at' => $this->whenNotNull($this->registration_start_at),
                'registration_end_at' => $this->whenNotNull($this->registration_end_at),
            ]),

            $this->mergeWhen($this->started || $this->registrationClosed, [
                'start_at' => $this->whenNotNull($this->start_at),
                'end_at' => $this->whenNotNull($this->end_at),
            ]),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
