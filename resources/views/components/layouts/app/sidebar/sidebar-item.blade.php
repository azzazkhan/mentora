<a
    href="{{ $href }}"
    class="{{
        cn([
            'flex items-center h-12 gap-x-2.5 text-sm px-2.5 line-clamp-1 truncate rounded-md',
            'text-primary-600 font-semibold active' => $active,
            'hover:bg-muted-foreground/15 transition-colors' => ! $active,
            $class
        ])
    }}"
    {{ $attributes }}
>
    @isset($icon)
        <div
            class="{{
                cn([
                    'size-8 aspect-square flex justify-center items-center overflow-hidden shrink-0',
                    $icon->attributes->get('class'),
                ])
            }}"
            {{ $icon->attributes->except('class') }}
        >
            {{ $icon }}
        </div>
    @endif

    {{ $slot }}
</a>
