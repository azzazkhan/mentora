<a
    href="{{ route('assignment.show', ['classroom' => $classroom, 'assignment' => $assignment]) }}"
    wire:navigate
    class="flex justify-between items-center gap-x-3 border border-muted-foreground/30 p-6 rounded-xl transition-colors hover:bg-muted/75"
>
    <div class="bg-primary-600 shrink-0 size-11 flex justify-center items-center rounded-full">
        <x-phosphor-clipboard-text-duotone class="text-white size-6.5" />
    </div>

    <div class="grow flex flex-col gap-y-1">
        <span class="font-medium text-sm line-clamp-1">
            {{ $classroom->teacher->user->name }} posted a new assignment: {{ $assignment->title }}
        </span>
        <p class="text-xs text-muted-foreground">
            <span>{{ $assignment->created_at->diffForHumans() }}</span>

            @if ($assignment->edited)
                <span>(edited)</span>
            @endif
        </p>
    </div>

    <button
        type="button"
        class="size-10 shrink-0 flex items-center justify-center rounded-full hover:bg-muted/50"
    >
        <x-heroicon-o-ellipsis-vertical class="size-5" />
    </button>
</a>
