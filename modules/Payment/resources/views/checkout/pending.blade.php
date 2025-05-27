<x-layouts.skeleton class="flex justify-center items-center p-20">
    <div class="w-full max-w-md p-6 flex flex-col items-center gap-y-4">
        <x-phosphor-clock-fill class="size-16 text-muted-foreground mx-auto" />

        <h3 class="text-lg font-medium">Transaction Pending</h3>

        <p class="text-sm text-muted-foreground text-center">
            We haven't received the payment for your order yet.
        </p>

        <a href="{{ $url }}" role="button" class="btn-ghost" rel="noreferrer">
            Retry
        </a>
    </div>
</x-layouts.skeleton>
