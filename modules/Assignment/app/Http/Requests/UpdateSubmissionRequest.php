<?php

namespace Modules\Assignment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Auth\Enums\Role;

class UpdateSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grade' => [
                'integer',
                'min:0',
                'max:100',
                Rule::excludeIf(! $this->user()->hasRole(Role::Teacher))
            ],

            'status' => [
                Rule::enum(Status::class)->only([Status::TurnedIn, Status::Pending]),
                Rule::excludeIf(! $this->user()->hasRole(Role::Teacher)),
            ],
        ];
    }
}
