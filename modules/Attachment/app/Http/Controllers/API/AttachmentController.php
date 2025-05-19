<?php

namespace Modules\Attachment\Http\Controllers\API;

use Modules\Attachment\Http\Controllers\Controller;
use Modules\Attachment\Http\Resources\AttachmentResource;
use Modules\Attachment\Models\Attachment;
use Illuminate\Http\JsonResponse;
use Modules\Attachment\Http\Requests\CreateAttachmentRequest;

class AttachmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAttachmentRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file('file');

        $attachment = $user->attachments()->create([
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'disk' => config('filesystems.default'),
            'path' => $file->store('attachments'),
        ]);

        return new AttachmentResource($attachment);
    }

    /**
     * Get the details of the specified attachment.
     */
    public function show(Attachment $attachment)
    {
        return new AttachmentResource($attachment);
    }

    /**
     * Delete the specified attachment.
     */
    public function destroy(Attachment $attachment): JsonResponse
    {
        $attachment->delete();

        return response()->json(status: 204);
    }
}
