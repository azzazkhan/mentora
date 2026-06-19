<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Modules\Assignment\Models\Assignment as AssignmentModel;
use Modules\Classroom\Models\Classroom;

class Assignment extends Component
{
    public Classroom $classroom;
    public AssignmentModel $assignment;

    public function mount(AssignmentModel $assignment)
    {

        $this->assignment = $assignment->load('attachments');
        $this->classroom = $assignment->classroom->load(['teacher' => ['user']]);
    }

    public function render()
    {
        return view('livewire.pages.assignment');
    }
}
