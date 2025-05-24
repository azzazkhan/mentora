<?php

namespace Modules\Assignment\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Assignment\Models\Assignment;
use Modules\Attachment\Models\Attachment;

/**
 * @method \App\Models\User user()
 * @method array only(array $keys)
 * @method \Illuminate\Support\Collection collect(string $key)
 * @method bool has(string $key)
 * @property-read \Modules\Assignment\Models\Assignment $assignment
 */
class UpdateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->assignment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['string'],
            'due_date' => ['date', Rule::date()->after(now()->addMinutes(5))],
            'attachments' => ['array', 'list', 'max:10'],
            'attachments.*' => [
                'uuid',
                Rule::exists(Attachment::class, 'uuid')
                    ->where(function (Builder $query) {
                        $query
                            ->where(function (Builder $query) {
                                $query
                                    ->where('attachable_type', Assignment::class)
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
