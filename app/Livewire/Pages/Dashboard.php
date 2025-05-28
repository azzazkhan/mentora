<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Classroom\Models\Classroom;

class Dashboard extends Component
{
    /**
     * @var Illuminate\Support\Collection<Classroom>
     */
    public Collection $classrooms;

    public function mount()
    {
        $this->classrooms = Auth::user()->classrooms()->with(['teacher' => ['user']])->get();
    }

    public function render()
    {
        return view('livewire.pages.dashboard', [
            'user' => User::first(),
        ]);
    }
}
