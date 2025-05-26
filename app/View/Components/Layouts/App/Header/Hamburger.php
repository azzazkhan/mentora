<?php

namespace App\View\Components\Layouts\App\Header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hamburger extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'button',
        public string|null $class = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app.header.hamburger');
    }
}
