<?php

namespace Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Http\Resources\RoleResource;

class UserResource extends JsonResource
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
            'email' => $this->whenHas('email'),
            'verified' => $this->when(! is_null($this->email_verified_at), (bool) $this->email_verified_at),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
