<button
    type="{{ $type }}"
    class="{{ cn('cursor-pointer inline-flex justify-center items-center size-12 rounded-full hover:bg-muted transition-colors', $class) }}"
    x-on:click.prevent="$store.layout.sidebar = ! $store.layout.sidebar"
    {{ $attributes }}
>
    <x-phosphor-list-duotone class="size-8" />
</button>
