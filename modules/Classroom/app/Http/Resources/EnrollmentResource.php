<?php

namespace Modules\Classroom\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->enrolled_at ? 'enrolled' : 'pending',
            'enrolled_at' => $this->whenHas('enrolled_at'),
        ];
    }
}
