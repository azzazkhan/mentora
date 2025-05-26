<button
    type="{{ $type }}"
    class="{{ cn('cursor-pointer inline-flex justify-center items-center size-12 rounded-full hover:bg-muted transition-colors', $class) }}"
    {{ $attributes }}
>
    <x-phosphor-list-duotone class="size-8" />
</button>
