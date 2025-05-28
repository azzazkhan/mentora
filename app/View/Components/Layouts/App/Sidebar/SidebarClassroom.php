<?php

namespace App\View\Components\Layouts\App\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Modules\Classroom\Models\Classroom;

class SidebarClassroom extends Component
{
    public string $path = '';
    public bool $active = false;

    /**
     * Create a new component instance.
     */
    public function __construct(Request $request, public Classroom $classroom)
    {
        $this->path = ltrim(route('classroom.show', ['classroom' => $this->classroom], absolute: false), '/');
        $this->active = $request->is($this->path) || $request->is("{$this->path}/*");
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app.sidebar.sidebar-classroom');
    }
}
