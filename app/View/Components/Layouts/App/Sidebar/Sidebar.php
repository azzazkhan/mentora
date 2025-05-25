<?php

namespace App\View\Components\Layouts\App\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Auth\Enums\Role;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = Auth::user();

        return view('components.layouts.app.sidebar.sidebar', [
            'dashboard' => match (true) {
                $user->hasRole(Role::Teacher) => 'Instructor Dashboard',
                $user->hasRole(Role::Student) => 'Student Dashboard',
            },
            'classrooms' => $user->classrooms()->get(),
        ]);
    }
}
