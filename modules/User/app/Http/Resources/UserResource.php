<?php

namespace Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Enums\Role;
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
            $this->mergeWhen(
                $request->user()->getKey() == $this->id ||
                    $request->user()->hasAnyRole([Role::SuperAdmin, Role::Admin]),
                fn() => ['email' => $this->whenHas('email'), 'verified' => (bool) $this->email_verified_at],
            ),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
