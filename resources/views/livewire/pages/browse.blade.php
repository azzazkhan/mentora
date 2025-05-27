<x-page>
    <div class="grid grid-cols-3 container gap-x-6 gap-y-10">
        @foreach ($classrooms as $classroom)
            <div
                wire:key="{{ $classroom->uuid }}"
                class="flex flex-col rounded-xl overflow-hidden border border-muted shadow transition-all hover:shadow-lg"
            >
                <div class="relative flex flex-col h-30 justify-between bg-cover bg-center p-4 text-white" style="background-image: url('{{ $classroom->cover->getThumbnailUrl() }}')">
                    <h3 class="text-xl font-medium truncate">{{ $classroom->name }}</h3>

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
                <div class="p-4 h-56 flex flex-col">
                    <p class="text-sm text-muted-foreground overlapped-text line-clamp-5">
                        {{ $classroom->description }}
                    </p>

                    <div class="mt-auto flex flex-col gap-y-4 pt-4">

                        @if ($classroom->registration_started_at->isFuture())
                            <p class="text-xs text-muted-foreground">
                                Registration starts from <span class="font-medium">{{ $classroom->registration_started_at->format('M jS, g:i A') }}</span>
                            </p>
                        @elseif ($classroom->registration_ended_at)
                            <p class="text-xs text-muted-foreground">
                                Registration ends on <span class="font-medium">{{ $classroom->registration_ended_at->format('M jS, g:i A') }}</span>
                            </p>
                        @endif

                        @unless ($classroom->registration_started_at->isFuture())
                            <button
                                class="btn"
                                wire:loading.attr="disabled"
                                wire:target="checkout('{{ $classroom->uuid }}')"
                                wire:click.prevent="checkout('{{ $classroom->uuid }}')"
                            >
                                <x-icon-loading
                                    wire:loading
                                    wire:target="checkout('{{ $classroom->uuid }}')"
                                    class="size-4 animate-spin"
                                />

                                <span>Enroll for <span class="uppercase">{{ config('cashier.currency') }}</span> {{ number_format($classroom->fee / 100) }}</span>
                            </button>
                        @else
                            <button
                                class="btn"
                                disabled
                            >
                                <span>Enroll for <span class="uppercase">{{ config('cashier.currency') }}</span> {{ number_format($classroom->fee / 100) }}</span>
                            </button>
                        @endunless
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-page>
