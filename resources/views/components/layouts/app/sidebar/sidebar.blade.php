<aside class="flex-shrink-0 flex flex-col w-3/12 max-w-80 bg-secondary-100 border-r border-secondary-200 h-dvh overflow-y-auto py-6">
    <a href="{{ url('/') }}" class="flex gap-x-2 mb-10 mx-6">
        <div class="bg-primary-600 flex justify-center items-center aspect-square size-10 overflow-hidden rounded-sm">
            <x-icon-mentora class="size-9 text-white" />
        </div>
        <div class="grid flex-1 text-left leading-tight">
            <span class="truncate font-semibold">{{ config('app.name') }}</span>
            <span class="truncate text-xs">{{ $dashboard }}</span>
        </div>
    </a>

    <span class="text-muted-foreground text-xxs font-semibold uppercase mx-6 mb-0.5">Menu</span>
    <div class="flex flex-col mx-4 mb-6">
        <x-layouts.app.sidebar.sidebar-item
            class="!h-11"
            wire:navigate href="{{ route('dashboard') }}"
            :active="request()->routeIs('dashboard')"
        >
            <x-slot:icon class="flex items-center justify-center">
                <x-phosphor-house-duotone class="size-5.5" />
            </x-slot:icon>

            <span class="grow">Home</span>
        </x-layouts.app.sidebar.sidebar-item>

        <x-layouts.app.sidebar.sidebar-item class="!h-11" wire:navigate>
            <x-slot:icon class="flex items-center justify-center">
                <x-phosphor-compass-duotone class="size-5.5" />
            </x-slot:icon>

            <span class="grow">Explore</span>
        </x-layouts.app.sidebar.sidebar-item>

        <x-layouts.app.sidebar.sidebar-item class="!h-11" wire:navigate>
            <x-slot:icon class="flex items-center justify-center">
                <x-phosphor-user-duotone class="size-5.5" />
            </x-slot:icon>

            <span class="grow">My Profile</span>
        </x-layouts.app.sidebar.sidebar-item>

        <x-layouts.app.sidebar.sidebar-item class="!h-11" wire:navigate>
            <x-slot:icon class="flex items-center justify-center">
                <x-phosphor-sliders-horizontal-duotone class="size-5.5" />
            </x-slot:icon>

            <span class="grow">Preferences</span>
        </x-layouts.app.sidebar.sidebar-item>
    </div>

    <span class="text-muted-foreground text-xxs font-semibold uppercase mx-6 mb-1">Classrooms</span>
    <div class="flex flex-col mx-4">
        @foreach ($classrooms as $classroom)
            <x-layouts.app.sidebar.sidebar-classroom :$classroom />
        @endforeach
    </div>
</aside>
