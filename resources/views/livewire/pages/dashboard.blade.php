@use('Modules\Classroom\Enums\Status')
<x-page>
    <div class="grid grid-cols-3 container gap-x-6 gap-y-10">
        @foreach ($classrooms as $classroom)
            <div
                wire:key="{{ $classroom->uuid }}"
                class="flex flex-col rounded-xl overflow-hidden border border-muted shadow transition-all hover:shadow-lg"
            >
                <div class="relative flex flex-col h-30 justify-between bg-cover bg-center p-4 text-white" style="background-image: url('{{ $classroom->cover->getThumbnailUrl() }}')">
                    <a href="{{ route('classroom.show', $classroom) }}" class="underline-offset-4 hover:underline" wire:navigate>
                        <h3 class="text-xl font-medium truncate">{{ $classroom->name }}</h3>
                    </a>

                    <span class="text-sm truncate mr-24">
                        {{ $classroom->teacher->user->name }}
                    </span>

                    <div class="absolute bg-white size-22 rounded-full bottom-0 right-4 overflow-hidden shadow transform translate-y-1/2">
                        <img
                            src="{{ $classroom->teacher->user->avatar }}"
                            class="size-full object-cover object-center"
                            alt="{{ $classroom->teacher->user->name }}"
                        />
                    </div>
                </div>
                <div class="p-4 h-40">
                    <p class="text-sm text-muted-foreground overlapped-text line-clamp-5">
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
                </div>
            </div>
        @endforeach
    </div>
</x-page>
