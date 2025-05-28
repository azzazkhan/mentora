<?php

namespace App\Livewire\Partials;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission as SubmissionModel;
use Modules\Attachment\Models\Attachment;

class Submission extends Component
{
    use WithFileUploads;

    public Assignment $assignment;
    public SubmissionModel $submission;
    public Collection $attachments;
    public $attachment;

    public function mount(Assignment $assignment)
    {
        $user = Auth::user();

        $this->assignment = $assignment;
        $this->submission = $assignment->submissions()->where('user_id', $user->getKey())->firstOrFail();
        $this->attachments = $this->submission->attachments;
    }

    public function render()
    {
        return view('livewire.partials.submission');
    }

    public function saveAttachment()
    {
        $attachment = new Attachment([
            'name' => $this->attachment->getClientOriginalName(),
            'size' => $this->attachment->getSize(),
            'mime_type' => $this->attachment->getMimeType(),
            'disk' => config('filesystems.default'),
            'path' => $this->attachment->store('attachments'),
        ]);

        $attachment->user()->associate(Auth::user());
        $attachment->attachable()->associate($this->submission);
        $attachment->save();

        $this->refreshAttachments();
    }

    public function removeAttachment(Attachment $attachment)
    {
        $attachment->delete();
        $this->refreshAttachments();
    }

    public function refreshAttachments()
    {
        $this->attachments = $this->submission->attachments;
    }

    #[Computed]
    public function disabled()
    {
        if (! is_null($this->submission->grade)) {
            return true;
        }

        return $this->assignment->due_date->isPast() && ! $this->assignment->allow_late;
    }

    #[Computed]
    public function missing()
    {
        return $this->assignment->due_date->isPast()
            && $this->submission->status->is([Status::Pending, Status::Missing]);
    }

    #[Computed]
    public function status()
    {
        return match (true) {
            ! is_null($this->submission->grade) => ['label' => "Graded {$this->submission->grade}/100", 'color' => 'text-green-600'],
            $this->missing() => ['label' => 'Missing', 'color' => 'text-red-500'],
            $this->submission->is_late => ['label' => 'Turned In Late', 'color' => ''],
            $this->turnedIn() => ['label' => 'Turned In', 'color' => ''],
            default => ['label' => 'Assigned', 'color' => 'text-green-600'],
        };
    }

    #[Computed]
    public function turnedIn()
    {
        return $this->submission->status->is([
            Status::TurnedIn,
            Status::Locked,
            Status::Processing,
            Status::Finalized,
        ]);
    }

    public function turnIn()
    {
        $this->submission->update([
            'status' => Status::TurnedIn,
            'is_late' => $this->assignment->due_date->isPast(),
            'submitted_at' => now(),
        ]);

        $this->submission->refresh();
    }

    public function turnBack()
    {
        $this->submission->update([
            'status' => Status::Pending,
            'is_late' => false,
            'submitted_at' => null,
        ]);

        $this->submission->refresh();
    }
}
