@use('Modules\Classroom\Enums\Status')
<x-page>
    <div class="container px-20">
        <div
            x-data="{ description: false }"
            class="flex flex-col rounded-2xl overflow-hidden bg-secondary-50 shadow transition-shadow"
            x-bind:class="{ 'shadow-lg': description }"
        >
            <div
                class="h-52 px-10 py-6 flex justify-between items-end gap-x-10 rounded-2xl bg-blue-800 bg-cover bg-center"
                style="background-image: url('{{ $classroom->cover->getOriginalPath() }}')"
            >
                <h1 class="text-3xl font-bold line-clamp-2 leading-snug grow text-white">
                    {{ $classroom->name }}
                </h1>

                @if ($classroom->description)
                    <button
                        type="button"
                        class="size-10 shrink-0 flex items-center justify-center rounded-full text-white hover:bg-muted-foreground/30"
                        x-on:click.prevent="description = !description"
                        x-bind:data-tooltip="description ? 'Hide description' : 'Show description'"
                    >
                        <x-heroicon-o-information-circle class="size-6" x-show="!description" />
                        <x-heroicon-s-information-circle class="size-6" x-show="description" />
                    </button>
                @endif
            </div>

            @if ($classroom->description)
                <div class="px-10 py-6 shadow" x-show="description" x-cloak x-collapse>
                    <p class="text-muted-foreground text-sm">
                        {{ str($classroom->description)->toHtmlString() }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div class="container flex gap-x-10 mt-10 px-20">
        <div class="shrink-0 w-60">
            <div class="border border-muted-foreground/30 p-6 rounded-xl">
                <h5>Details</h5>

                <p class="text-muted-foreground text-sm mt-4">
                    @if ($classroom->status->is([Status::RegistrationOpen, Status::RegistrationClosed]))
                        Starting in {{ $classroom->started_at->diffForHumans() }}
                    @elseif ($classroom->status->is(Status::Started))
                        Ending in {{ $classroom->ended_at->diffForHumans() }}
                    @elseif ($classroom->status->is(Status::Ended))
                        Ended {{ $classroom->ended_at->diffForHumans() }}
                    @elseif ($classroom->status->is(Status::Paused))
                        Paused
                    @elseif ($classroom->status->is(Status::Archived))
                        Archived
                    @endif
                </p>

                <div class="pt-4">
                    <a
                        href="{{ route('livestream.show', $classroom) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md mt-8">
                        Join Livestream
                    </a>
                </div>
            </div>
        </div>

        <div class="grow flex flex-col gap-y-8">
            @foreach ($activities as $activity)
                <div wire:key="{{ $activity->uuid }}">
                    @switch ($activity->subject_type)
                        @case ($types->announcement)
                            <x-partials.classroom.announcement-item :announcement="$activity->subject" :$classroom />
                        @break

                        @case ($types->assignment)
                            <x-partials.classroom.assignment-item :assignment="$activity->subject" :$classroom />
                        @break
                    @endswitch
                </div>

            @endforeach
        </div>
    </div>
</x-page>
