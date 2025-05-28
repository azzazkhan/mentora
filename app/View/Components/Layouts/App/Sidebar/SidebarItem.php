<?php

namespace App\View\Components\Layouts\App\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $href = 'javascript:void(0)',
        public bool $active = false,
        public string|null $class = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app.sidebar.sidebar-item');
    }
}
