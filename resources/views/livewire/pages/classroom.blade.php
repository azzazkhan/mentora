<x-page>
    <div class="container px-20">
        <div
            x-data="{ description: false }"
            class="flex flex-col rounded-2xl overflow-hidden bg-secondary-50 shadow transition-shadow"
            x-bind:class="{ 'shadow-lg': description }"
        >
            <div
                class="h-52 px-10 py-6 flex justify-between items-end gap-x-10 rounded-2xl bg-cover bg-center"
                style="background-image: url('https://gstatic.com/classroom/themes/img_code.jpg')"
            >
                <h1 class="text-3xl font-bold line-clamp-2 leading-snug grow text-white">
                    {{ $classroom->name }}
                </h1>

                @if ($classroom->description)
                    <button
                        type="button"
                        class="size-10 shrink-0 flex items-center justify-center rounded-full text-white hover:bg-muted-foreground/30"
                        x-on:click.prevent="description = !description"
                    >
                        <x-heroicon-o-information-circle class="size-6" x-show="!description" />
                        <x-heroicon-s-information-circle class="size-6" x-show="description" />
                    </button>
                @endif
            </div>

            @if ($classroom->description)
                <div class="px-10 py-6 shadow" x-show="description" x-collapse>
                    <p class="text-muted-foreground text-sm">
                        {{ $classroom->description }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div class="container flex gap-x-10 mt-10 px-20">
        <div class="shrink-0 w-60">
            <div class="border border-muted-foreground/30 p-6 rounded-xl">
                <h5>Upcoming</h5>

                <p class="text-muted-foreground text-sm mt-4">Woohoo, no work due soon!</p>
            </div>
        </div>

        <div class="grow flex flex-col gap-y-8">
            <div>
                <x-dropdown>
                    <button type="button" aria-haspopup="menu" aria-expanded="false" x-bind="$trigger" id="dropdown-menu-trigger" aria-controls="dropdown-menu-menu" class="btn-outline">Open</button>

                    <x-dropdown.menu>
                        <x-dropdown.group heading="My Account">
                            <x-dropdown.menu-item>
                                Billing
                                <x-dropdown.command>⌘B</x-dropdown.command>
                            </x-dropdown.menu-item>

                            <x-dropdown.menu-item>
                                Settings
                                <x-dropdown.command>⌘S</x-dropdown.command>
                            </x-dropdown.menu-item>

                            <x-dropdown.menu-item>
                                Keyboard shortcuts
                                <x-dropdown.command>⌘K</x-dropdown.command>
                            </x-dropdown.menu-item>
                        </x-dropdown.group>

                        <x-dropdown.separator />

                        <x-dropdown.menu-item>GitHub</x-dropdown.menu-item>
                        <x-dropdown.menu-item>Support</x-dropdown.menu-item>
                        <x-dropdown.menu-item disabled>API</x-dropdown.menu-item>

                        <x-dropdown.separator />

                        <x-dropdown.menu-item>
                            Logout
                            <x-dropdown.command>⇧⌘P</x-dropdown.command>
                        </x-dropdown.menu-item>
                    </x-dropdown.menu>
                </x-dropdown>
            </div>

            @foreach ($activities as $activity)

                @switch ($activity->subject_type)
                    @case ($types->announcement)
                        <x-partials.classroom.announcement-item :announcement="$activity->subject" :$classroom />
                    @break

                    @case ($types->assignment)
                        <x-partials.classroom.assignment-item :assignment="$activity->subject" :$classroom />
                    @break
                @endswitch

            @endforeach
        </div>
    </div>
</x-page>
