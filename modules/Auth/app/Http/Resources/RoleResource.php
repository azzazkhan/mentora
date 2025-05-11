<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Enums\Role;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = Role::from($this->name);

        return [
            'label' => $role->getLabel(),
            'value' => $role->value,
        ];
    }
}
