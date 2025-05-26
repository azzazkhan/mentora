<div class="border border-muted-foreground/30 p-6 rounded-xl">
    <div class="flex justify-between items-center gap-x-3">
        <div class="shrink-0 size-11 rounded-full overflow-hidden">
            <img
                src="{{ image($classroom->teacher->user->avatar) }}"
                class="size-full object-cover object-center"
                alt="{{ $classroom->teacher->user->name }}"
            />
        </div>

        <div class="grow flex flex-col gap-y-1">
            <span class="font-medium text-sm line-clamp-1">
                {{ $classroom->teacher->user->name }}
            </span>
            <p class="text-xs text-muted-foreground">
                <span>{{ $announcement->created_at->diffForHumans() }}</span>

                @if ($announcement->edited)
                    <span>(edited)</span>
                @endif
            </p>
        </div>

        <x-dropdown>
            <button
                type="button"
                aria-haspopup="menu"
                aria-expanded="false"
                x-bind="$trigger"
                class="size-10 shrink-0 flex items-center justify-center rounded-full hover:bg-muted/50"
            >
                <x-heroicon-o-ellipsis-vertical class="size-5" />
            </button>

            <x-dropdown.menu data-align="end" class="min-w-min w-36">
                <x-dropdown.menu-item
                    as="a"
                    wire:navigate
                    href="{{ route('announcement.show', ['classroom' => $classroom, 'announcement' => $announcement]) }}"
                >
                    <x-fas-eye class="size-4 mr-1" />
                    <span>Preview</span>
                </x-dropdown.menu-item>

                <x-dropdown.menu-item>
                    <x-fas-paperclip class="size-4 mr-1" />
                    <span>Copy Link</span>
                </x-dropdown.menu-item>
            </x-dropdown.menu>
        </x-dropdown>
    </div>

    <p class="text-muted-foreground text-sm whitespace-pre-wrap mt-4">{{ $announcement->content }}</p>
</div>
