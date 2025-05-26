<x-page>
    <div class="container grid grid-cols-10 gap-x-10">
        <div class="col-span-7 flex gap-x-3">
            <div class="shrink-0 bg-primary-600 flex items-center justify-center size-12 rounded-full">
                <x-phosphor-clipboard-text class="size-6 text-white" />
            </div>

            <div class="grow">
                <div class="flex justify-between gap-x-4 pb-4 border-b border-muted-foreground/25">
                    <div class="grow flex flex-col gap-y-1">
                        <h1 class="text-2xl line-clamp-2">{{ $assignment->title }}</h1>
                        <p class="text-sm text-muted-foreground flex flex-wrap items-center gap-x-0.5 gap-y-2">
                            <span>{{ $classroom->teacher->user->name }}</span>
                            <x-phosphor-dot-bold class="size-4 transform scale-200" />
                            <span>{{ $assignment->created_at->diffForHumans() }}</span>
                        </p>

                        @if ($assignment->due_date->isFuture())
                            <p class="mt-1 text-sm">Due in {{ $assignment->due_date->diffForHumans() }}</p>
                        @else
                            <p class="mt-1 text-sm">Due {{ $assignment->due_date->diffForHumans() }}</p>
                        @endif

                    </div>

                    <div class="shrink-0">
                        <x-dropdown>
                            <button
                                type="button"
                                aria-haspopup="menu"
                                aria-expanded="false"
                                x-bind="$trigger"
                                class="size-10 flex items-center justify-center rounded-full hover:bg-muted/50"
                            >
                                <x-fas-ellipsis-vertical class="size-4.5" />
                            </button>

                            <x-dropdown.menu data-align="end" class="min-w-min w-36">
                                <x-dropdown.menu-item x-on:click.prevent="$clipboard('{{ request()->url() }}')">
                                    <x-fas-paperclip class="size-4 mr-1" />
                                    <span>Copy Link</span>
                                </x-dropdown.menu-item>
                            </x-dropdown.menu>
                        </x-dropdown>
                    </div>
                </div>

                <p class="text-muted-foreground text-sm whitespace-pre-wrap my-4">{{ $assignment->description }}</p>
            </div>
        </div>

        <div class="col-span-3">
            <livewire:partials.submission :assignment="$assignment" />
        </div>
    </div>
</x-page>
