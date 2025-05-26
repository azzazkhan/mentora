<div
    class="p-6 border border-muted rounded-lg shadow-lg"
    x-data="{ uploading: false, progress: 0 }"
    x-on:refresh-attachments.window="$wire.refreshAttachments()"
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false; $refs.button.click();"
    x-on:livewire-upload-cancel="uploading = false"
    x-on:livewire-upload-error="uploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <div class="flex justify-between items-center">
        <span class="text-lg">Your Work</span>
        <span class="text-sm font-medium {{ $this->status['color'] }}">{{ $this->status['label'] }}</span>
    </div>

    <div class="flex flex-col gap-y-2 mt-4">
        @foreach ($attachments as $attachment)
            <div class="flex items-center justify-between gap-x-4 px-3 h-10 rounded-md border border-muted-foreground/25">
                <div class="grow">
                    <a
                        href="{{ Storage::disk($attachment->disk)->temporaryUrl($attachment->path, now()->addMinutes(10)) }}"
                        class="text-sm font-medium underline-offset-4 line-clamp-1 max-w-max hover:underline"
                        target="_blank"
                    >
                        {{ $attachment->name }}
                    </a>
                </div>

                @unless ($this->disabled || $this->turnedIn)
                    <button
                        type="button"
                        class="size-8 shrink-0 flex items-center justify-center rounded-full text-muted-foreground hover:bg-muted-foreground/15"
                        wire:click.prevent="removeAttachment('{{ $attachment->uuid }}')"
                        data-tooltip="Remove attachment"
                    >
                        <x-heroicon-o-x-mark class="size-4" />
                    </button>
                @endunless
            </div>
        @endforeach
    </div>

    @if ($this->turnedIn && $this->attachments->isEmpty())
        <p class="text-muted-foreground text-sm text-center my-4">No work attached</p>
    @endif

    @unless ($this->disabled || $this->turnedIn)
        <form wire:submit.prevent="saveAttachment">
            <input
                type="file"
                class="hidden"
                x-ref="attachmentInput"
                wire:model="attachment"
            />

            <button
                type="button"
                class="btn-outline relative text-primary-600 overflow-hidden w-full py-4 px-8 mt-4"
                x-on:click.prevent="$refs.attachmentInput.click()"
                wire:loading.attr="disabled"
                {{-- wire:target="attachment" --}}
            >
                <span>Add file</span>

                <div
                    x-cloak
                    x-show="uploading"
                    class="absolute -left-1 bottom-0 w-[calc(100%+0.25rem)] bg-muted"
                >
                    <div class="bg-primary-500 h-1 rounded-full" x-bind:style="{ width: `${progress}%` }"></div>
                </div>
            </button>

            <button type="submit" class="hidden" x-ref="button"></button>
        </form>
    @endunless

    @if ($this->turnedIn)

        @if ($this->disabled)
            <button type="button" class="btn-outline w-full py-4.5 px-8 mt-6" disabled>
                Unsubmit
            </button>
        @else
            <button
                type="button" class="btn-outline w-full py-4.5 px-8 mt-6"
                wire:loading.attr="disabled"
                wire:click.prevent="turnBack"
            >
                Unsubmit
            </button>
        @endif

    @else
        @if ($this->disabled)
            <button type="button" class="btn w-full py-5 px-8 mt-6" disabled>
                @if ($attachments->isEmpty())
                    Mark as done
                @else
                    Turn In
                @endif
            </button>
        @else
            <button
                type="button"
                class="btn w-full py-5 px-8 mt-6 bg-primary-600 hover:bg-primary-500"
                wire:loading.attr="disabled"
                wire:click.prevent="turnIn"
            >
                @if ($attachments->isEmpty())
                    Mark as done
                @else
                    Turn In
                @endif
            </button>
        @endif
    @endif

    {{-- @if ($this->disabled)
        <button type="button" class="btn w-full py-5 px-8 mt-6" disabled>
            @if ($attachments->isEmpty())
                Mark as done
            @else
                Turn In
            @endif
        </button>
    @else
        <button
            type="button"
            class="btn w-full py-5 px-8 mt-6 bg-primary-600 hover:bg-primary-500"
            wire:loading.attr="disabled"
            wire:click.prevent="turnIn"
        >
            @if ($attachments->isEmpty())
                Mark as done
            @else
                Turn In
            @endif
        </button>
    @endif --}}

    @unless ($assignment->allow_late)
        <p class="text-xs text-muted-foreground italic text-center mt-4">
            Work cannot be turned in after the due date
        </p>
    @endunless
</div>
