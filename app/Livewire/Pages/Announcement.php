<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Modules\Announcement\Models\Announcement as AnnouncementModel;
use Modules\Classroom\Models\Classroom;

class Announcement extends Component
{
    public Classroom $classroom;
    public AnnouncementModel $announcement;

    public function mount(Classroom $classroom, AnnouncementModel $announcement)
    {
        $this->classroom = $classroom;
        $this->classroom->load(['teacher' => ['user']]);

        $this->announcement = $announcement;
        $this->announcement->load('attachments');
    }

    public function render()
    {
        return view('livewire.pages.announcement');
    }
}
