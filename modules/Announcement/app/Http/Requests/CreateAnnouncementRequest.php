<?php

namespace Modules\Announcement\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Announcement\Models\Announcement;
use Modules\Attachment\Models\Attachment;

/**
 * @method \App\Models\User user()
 * @method array|mixed only(string|array $keys)
 * @method array array(array|string|null $key)
 * @method \Illuminate\Support\Collection collect(array|string|null $key)
 * @property-read \Modules\Classroom\Models\Classroom $classroom
 */
class CreateAnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', [Announcement::class, $this->classroom]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'attachments' => ['required', 'array', 'list'],
            'attachments.*' => [
                'uuid',
                Rule::exists(Attachment::class, 'uuid')
                    ->where('user_id', $this->user()->getKey())
                    ->where(function (Builder $query) {
                        $query->whereNull('attachable_type')->whereNull('attachable_id');
                    }),
            ],
        ];
    }
}
