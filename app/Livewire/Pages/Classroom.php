<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Modules\Announcement\Models\Announcement;
use Modules\Assignment\Models\Assignment;
use Modules\Classroom\Models\Classroom as ClassroomModel;

class Classroom extends Component
{
    public ClassroomModel $classroom;

    public function mount(ClassroomModel $classroom)
    {
        $this->classroom = $classroom->load(['teacher' => ['user']]);
    }

    public function render()
    {
        return view('livewire.pages.classroom', [
            'activities' => $this->getActivities(),
            'types' => (object) [
                'announcement' => Announcement::class,
                'assignment' => Assignment::class,
            ],
        ]);
    }

    protected function getActivities()
    {
        return $this->classroom->activities()->with('subject')->get();
    }
}
