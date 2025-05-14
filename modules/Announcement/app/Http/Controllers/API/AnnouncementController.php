<?php

namespace Modules\Announcement\Http\Controllers\API;

use Modules\Announcement\Http\Controllers\Controller;
use Modules\Announcement\Http\Requests\CreateAnnouncementRequest;
use Modules\Announcement\Http\Requests\UpdateAnnouncementRequest;
use Modules\Announcement\Http\Resources\AnnouncementResource;
use Modules\Announcement\Models\Announcement;
use Modules\Classroom\Models\Classroom;

class AnnouncementController extends Controller
{
    /**
     * Show all the announcements for specified classroom.
     */
    public function index(Classroom $classroom)
    {
        $announcements = $classroom
            ->announcements()
            ->with(['teacher' => ['user']])
            ->paginate(10);

        return AnnouncementResource::collection($announcements);
    }

    /**
     * Create a new announcement in the specified classroom.
     */
    public function store(CreateAnnouncementRequest $request, Classroom $classroom)
    {
        $announcement = $classroom->announcements()->create($request->validated());

        return new AnnouncementResource($announcement);
    }

    /**
     * Show the details of the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        return new AnnouncementResource($announcement);
    }

    /**
     * Update the specified announcement.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update(array_merge($request->validated(), [
            'edited' => true,
        ]));

        return new AnnouncementResource($announcement);
    }

    /**
     * Delete the specified announcement.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return response()->json(null, 204);
    }
}
