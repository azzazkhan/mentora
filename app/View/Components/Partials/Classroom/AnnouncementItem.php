<?php

namespace App\View\Components\Partials\Classroom;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Announcement\Models\Announcement;
use Modules\Classroom\Models\Classroom;

class AnnouncementItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Announcement $announcement,
        public Classroom $classroom,
    ) {
        $classroom->load(['teacher' => ['user']]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.classroom.announcement-item');
    }
}
