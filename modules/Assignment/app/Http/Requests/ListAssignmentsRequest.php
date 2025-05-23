<?php

namespace Modules\Assignment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Modules\Assignment\Enums\Status;
use Modules\Assignment\Models\Assignment;

/**
 * @property-read \Modules\Classroom\Models\Classroom $classroom
 */
class ListAssignmentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('list', [Assignment::class, $this->classroom]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', new Enum(Status::class)],
        ];
    }
}
