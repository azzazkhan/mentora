<?php

namespace Modules\User\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

/**
 * @method \App\Models\User user()
 * @method \Illuminate\Http\UploadedFile|null file(string $name)
 * @method string|null string(string $name)
 */
class UpdateUserRequest extends FormRequest
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
            'name' => ['string', 'min:3', 'max:255'],
            'email' => ['string', 'email', Rule::unique(User::class)->ignore($this->user())],
            'avatar' => File::image()->min(50)->max(2 * 1024),
            'password' => ['string', Password::defaults()],
        ];
    }
}
