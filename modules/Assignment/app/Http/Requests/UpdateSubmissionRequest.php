<?php

namespace Modules\Assignment\Http\Requests;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Models\Submission;
use Modules\Attachment\Models\Attachment;
use Modules\Auth\Enums\Role;

/**
 * @method \App\Models\User user()
 * @method array only(array $keys)
 * @method array array(string $key)
 * @method bool has(string $key)
 * @method \Illuminate\Support\Collection collect(string $key)
 * @property-read \Modules\Assignment\Models\Assignment $assignment
 * @property-read \Modules\Assignment\Models\Submission $submission
 */
class UpdateSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->submission);
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
                Rule::excludeIf($this->assignment->classroom->teacher()->isNot($this->user()->teacher)),
            ],

            'status' => [
                'string',
                Rule::enum(Status::class)->only([Status::TurnedIn, Status::Pending]),
                Rule::excludeIf($this->submission->user()->isNot($this->user())),
            ],

            'attachments' => [
                'array',
                'list',
                'max:10',
                Rule::excludeIf($this->submission->user()->isNot($this->user())),
            ],

            'attachments.*' => [
                'uuid',
                Rule::exists(Attachment::class, 'uuid')
                    ->where(function (Builder $query) {
                        $query
                            ->where(function (Builder $query) {
                                $query
                                    ->where('attachable_type', Submission::class)
                                    ->where('attachable_id', $this->assignment->getKey());
                            })
                            ->orWhere(function (Builder $query) {
                                $query
                                    ->where('user_id', $this->user()->getKey())
                                    ->whereNull('attachable_type')
                                    ->whereNull('attachable_id');
                            });
                    }),
            ],
        ];
    }
}
