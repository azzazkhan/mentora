@props(['class' => null])
<span
    class="{{ cn('text-muted-foreground ml-auto text-xs tracking-widest', $class) }}"
    {{ $attributes }}
>
    {{ $slot }}
</span>
