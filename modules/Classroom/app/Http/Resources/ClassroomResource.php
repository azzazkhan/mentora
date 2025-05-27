<?php

namespace Modules\Classroom\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Enums\Status;
use Modules\User\Http\Resources\TeacherResource;

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

            'cover' => $this->cover->getOriginalUrl(),
            'color' => $this->color,

            $this->mergeWhen($this->pending || $this->registrationOpen, [
                'registration_started_at' => $this->whenNotNull($this->registration_started_at),
                'registration_ended_at' => $this->whenNotNull($this->registration_ended_at),
            ]),

            $this->mergeWhen($this->started || $this->registrationClosed, [
                'started_at' => $this->whenNotNull($this->started_at),
                'ended_at' => $this->whenNotNull($this->ended_at),
            ]),

            'teacher' => new TeacherResource($this->whenLoaded('teacher')),

            'enrollment' => $this->when($request->user()->hasRole(Role::Student), function () {
                return new EnrollmentResource($this->whenLoaded('enrollment'));
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
