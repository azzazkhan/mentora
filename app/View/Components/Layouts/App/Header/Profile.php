<?php

namespace App\View\Components\Layouts\App\Header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Profile extends Component
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

        return view('components.layouts.app.header.profile', [
            'name' => $user->name,
            'avatar' => $user->avatar,
            'email' => $user->email,
        ]);
    }
}
