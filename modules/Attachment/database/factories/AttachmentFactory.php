<?php

namespace Modules\Attachment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Attachment\Models\Attachment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Attachment\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
