<?php

namespace App\Livewire\Pages;

use App\AgoraRTC\RtcTokenBuilder2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Classroom\Models\Classroom;
use Modules\Livestream\Models\Livestream as LivestreamModel;

#[Layout('components.layouts.skeleton')]
class Livestream extends Component
{
    public Classroom $classroom;
    public LivestreamModel $livestream;
    public bool $joined = false;
    public string $role = 'host';
    public string $channel;
    public string $uid;
    public string $token;

    public function mount(Classroom $classroom)
    {
        $this->classroom = $classroom;
        $livestream = $this->classroom->livestreams()->where('ends_at', '>', now()->addMinutes(30))->first();

        if (! $livestream) {
            $livestream = $this->classroom->livestreams()->create([
                'title' => 'Livestream',
                'description' => 'Livestream',
                'starts_at' => now(),
                'ends_at' => now()->addHours(1),
            ]);
        }

        $this->livestream = $livestream;
        $this->role = Auth::user()->teacher?->is($classroom->teacher) ? 'teacher' : 'student';
        $this->channel = $this->livestream->uuid;
        $this->uid = '*';
        $this->token = (string) $this->getToken();
    }

    public function join()
    {
        $this->joined = true;
    }

    public function render()
    {
        return view('livewire.pages.livestream');
    }

    protected function getToken()
    {
        return RtcTokenBuilder2::buildTokenWithUid(
            config('services.agora.app_id'),
            config('services.agora.app_certificate'),
            $this->livestream->uuid,
            $this->uid,
            $this->role == 'teacher' ? RtcTokenBuilder2::ROLE_PUBLISHER : RtcTokenBuilder2::ROLE_SUBSCRIBER,
            3600,
            3600,
        );
    }
}
