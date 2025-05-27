<x-layouts.skeleton class="flex justify-center items-center p-20">
    <div class="w-full max-w-md p-6 flex flex-col items-center gap-y-4">
        <x-phosphor-x-circle-fill class="size-16 text-red-600 mx-auto" />

        <h3 class="text-lg font-medium">Payment Failed</h3>

        <p class="text-sm text-muted-foreground text-center">
            Either your order was cancelled or expired.
        </p>

        <a href="{{ route('dashboard') }}" role="button" class="btn-ghost" wire:navigate>
            Go Home
        </a>
    </div>
</x-layouts.skeleton>
