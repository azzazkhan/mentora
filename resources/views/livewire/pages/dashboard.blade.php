<x-page>
    <div class="grid grid-cols-3 container gap-x-6 gap-y-10">
        @foreach ($classrooms as $classroom)
            <div
                wire:key="{{ $classroom->uuid }}"
                class="flex flex-col rounded-xl overflow-hidden border border-muted shadow transition-all hover:shadow-lg"
            >
                <div class="relative flex flex-col h-30 justify-between bg-blue-900 p-4 text-white">
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
                <div class="p-4 h-56"></div>
            </div>
        @endforeach
    </div>
</x-page>
