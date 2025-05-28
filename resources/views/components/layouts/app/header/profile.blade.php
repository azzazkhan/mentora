<x-dropdown>
    <button
        type="button"
        aria-haspopup="menu"
        aria-expanded="false"
        x-bind="$trigger"
        class="aspect-square rounded-full overflow-hidden size-10 border border-muted-foreground/50"
    >
        <img
            src="{{ image($avatar) }}"
            class="size-full object-cover object-center"
            alt="{{ image($name) }}"
        />
    </button>

    <x-dropdown.menu data-align="end" class="min-w-min w-36">
        <form action="{{ route('auth::logout') }}" method="POST">
            @csrf

            <x-dropdown.menu-item type="submit">
                <x-fas-eye class="size-4 mr-1" />
                <span>Logout</span>
            </x-dropdown.menu-item>
        </form>
    </x-dropdown.menu>
</x-dropdown>
