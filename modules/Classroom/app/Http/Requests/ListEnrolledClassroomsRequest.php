<?php

namespace Modules\Classroom\Http\Requests;

use App\Enums\Form\TernaryValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Auth\Enums\Role;

/**
 * @method \App\Models\User user()
 * @method \BackedEnum|null enum(string $name, \BackedEnum $enum, \BackedEnum|null $default = null)
 */
class ListEnrolledClassroomsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole(Role::Student);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pending' => [Rule::enum(TernaryValue::class)],
        ];
    }
}
