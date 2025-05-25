<?php

namespace App\View\Components\Layouts\App\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Classroom\Models\Classroom;

class SidebarClassroom extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Classroom $classroom)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app.sidebar.sidebar-classroom');
    }
}
