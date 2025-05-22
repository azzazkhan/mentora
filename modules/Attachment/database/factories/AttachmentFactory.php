<?php

namespace Modules\Attachment\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        return array_merge([
            'user_id' => User::factory(),
        ], $this->getFile());
    }

    protected function getFile(): array
    {
        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        $file = collect(File::files(resource_path('data/documents')))->random();
        $path = Storage::putFile('attachments', new HttpFile($file->getPathname()));

        return [
            'name' => $file->getFilename(),
            'size' => File::size($file->getPathname()),
            'mime_type' => File::mimeType($file->getPathname()),
            'disk' => config('filesystems.default'),
            'path' => $path,
        ];
    }
}
