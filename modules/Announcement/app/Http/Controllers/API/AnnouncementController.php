<?php

namespace Modules\Announcement\Http\Controllers\API;

use App\Enums\Pagination;
use Modules\Announcement\Http\Controllers\Controller;
use Modules\Announcement\Http\Requests\CreateAnnouncementRequest;
use Modules\Announcement\Http\Requests\DeleteAnnouncementsRequest;
use Modules\Announcement\Http\Requests\ListAnnouncementsRequest;
use Modules\Announcement\Http\Requests\UpdateAnnouncementRequest;
use Modules\Announcement\Http\Resources\AnnouncementResource;
use Modules\Announcement\Models\Announcement;
use Modules\Attachment\Models\Attachment;
use Modules\Classroom\Models\Classroom;

class AnnouncementController extends Controller
{
    /**
     * Show all the announcements for specified classroom.
     */
    public function index(ListAnnouncementsRequest $request, Classroom $classroom)
    {
        $query = $classroom->announcements()->with(['teacher' => ['user']]);

        return AnnouncementResource::collection(
            paginate($query, type: Pagination::Cursor)
        );
    }

    /**
     * Create a new announcement in the specified classroom.
     */
    public function store(CreateAnnouncementRequest $request, Classroom $classroom)
    {
        $user = $request->user();

        abort_unless($user->teacher, 403);

        $announcement = new Announcement($request->only(['title', 'content']));
        $announcement->classroom()->associate($classroom);
        $announcement->teacher()->associate($user->teacher);
        $announcement->save();

        /** @var list<string> $attachments */
        $attachments = $request->collect('attachments')->unique()->values()->all();

        $user
            ->attachments()
            ->whereIn('uuid', $attachments)
            ->update([
                'attachable_type' => Announcement::class,
                'attachable_id' => $announcement->getKey()
            ]);

        $announcement->setRelation(
            'attachments',
            Attachment::whereIn('uuid', $attachments)->get()
        );

        return new AnnouncementResource($announcement);
    }

    /**
     * Show the details of the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        $announcement->load(['teacher' => ['user'], 'attachments']);

        return new AnnouncementResource($announcement);
    }

    /**
     * Update the specified announcement.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update(array_merge($request->only(['content']), [
            'edited' => true,
        ]));

        /** @var list<string> $attachments */
        $attachments = $request->collect('attachments')->unique()->values()->all();

        // Scheduled task will auto-delete stale non-attached files
        $announcement->attachments()->whereNotIn('uuid', $attachments)->update([
            'attachable_type' => null,
            'attachable_id' => null,
        ]);

        $request
            ->user()
            ->attachments()
            ->whereIn('uuid', $attachments)
            ->update([
                'attachable_type' => Announcement::class,
                'attachable_id' => $announcement->getKey()
            ]);

        $announcement->setRelation(
            'attachments',
            Attachment::whereIn('uuid', $attachments)->get()
        );

        return new AnnouncementResource($announcement->load(['teacher' => ['user']]));
    }

    /**
     * Delete the specified announcement.
     */
    public function destroy(DeleteAnnouncementsRequest $request, Announcement $announcement)
    {
        $announcement->delete();

        return response()->json(null, 204);
    }
}
