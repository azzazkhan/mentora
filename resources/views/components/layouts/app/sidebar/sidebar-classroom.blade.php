<x-layouts.app.sidebar.sidebar-item
    href="{{ route('classroom.show', $classroom) }}"
    wire:navigate
    :$active
>
    <x-slot:icon class="bg-muted-foreground/15 rounded-full">
        <span class="text-sm font-medium uppercase text-black">{{ initials($classroom->name) }}</span>
    </x-slot:icon>

    <span class="grow truncate">{{ $classroom->name }}</span>
</x-layouts.app.sidebar.sidebar-item>
