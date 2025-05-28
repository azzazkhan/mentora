<x-page>
    <div class="mx-auto flex gap-x-3 max-w-3xl">
        <div class="shrink-0 bg-primary-600 flex items-center justify-center size-12 rounded-full">
            <x-phosphor-chat class="size-6 text-white" />
        </div>

        <div class="grow">
            <div class="flex justify-between gap-x-4 pb-4 border-b border-muted-foreground/25">
                <div class="grow flex flex-col gap-y-1">
                    <h1 class="text-2xl">Announcement</h1>
                    <p class="text-sm text-muted-foreground flex flex-wrap items-center gap-x-0.5 gap-y-2">
                        <span>{{ $classroom->teacher->user->name }}</span>
                        <x-phosphor-dot-bold class="size-4 transform scale-200" />
                        <span>{{ $announcement->created_at->diffForHumans() }}</span>
                    </p>
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

            <p class="text-muted-foreground text-sm my-4">
                {{ str($announcement->content)->toHtmlString() }}
            </p>
        </div>
    </div>
</x-page>
