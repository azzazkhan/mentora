<x-layouts.skeleton class="flex justify-center items-center p-20">
    <div
        x-data="{ timer: 5 }"
        x-init="setInterval(() => (timer = timer <= 0 ? 0 : timer - 1), 1000)"
        x-effect="timer == 0 && Livewire.navigate('{{ $route }}')"
        class="w-full max-w-md p-6 flex flex-col items-center"
    >
        <x-phosphor-check-circle-fill class="size-16 text-green-600 mx-auto mb-4" />

        <h3 class="text-lg font-medium">Payment Successful</h3>

        <p class="text-sm text-muted-foreground text-center mt-4">
            We've received a payment of <strong>{{ $currency }} {{ $amount }}</strong>. You will be redirected in <span x-text="timer"></span> seconds.
        </p>
    </div>
</x-layouts.skeleton>
