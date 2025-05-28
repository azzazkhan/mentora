<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Modules\Assignment\Models\Assignment as AssignmentModel;
use Modules\Classroom\Models\Classroom;

class Assignment extends Component
{
    public Classroom $classroom;
    public AssignmentModel $assignment;

    public function mount(Classroom $classroom, AssignmentModel $assignment)
    {
        $this->classroom = $classroom;
        $this->classroom->load(['teacher' => ['user']]);

        $this->assignment = $assignment;
        $this->assignment->load('attachments');
    }

    public function render()
    {
        return view('livewire.pages.assignment');
    }
}
