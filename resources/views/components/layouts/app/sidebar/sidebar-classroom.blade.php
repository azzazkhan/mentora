<x-layouts.app.sidebar.sidebar-item>
    <x-slot:icon class="bg-muted-foreground/15">
        <img
            src="{{ $classroom->icon }}"
            class="size-8 object-cover object-center"
            alt="{{ $classroom->name }}"
        />
    </x-slot:icon>

    <span class="grow truncate">{{ $classroom->name }}</span>
</x-layouts.app.sidebar.sidebar-item>
