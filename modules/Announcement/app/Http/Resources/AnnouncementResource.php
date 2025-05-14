<?php

namespace Modules\Announcement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Classroom\Http\Resources\ClassroomResource;
use Modules\User\Http\Resources\TeacherResource;

class AnnouncementResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'classroom' => new ClassroomResource($this->whenLoaded('classroom')),
            'edited' => $this->edited,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
