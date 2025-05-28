<a
    href="{{ $href }}"
    class="{{
        cn([
            'inline-flex items-center gap-x-2 h-11 px-4 rounded-sm',
            'bg-primary-500/15 text-primary-600 font-medium' => $active,
            'hover:bg-secondary-100 transition-colors' => !$active,
            $class,
        ])
    }}"
>
    {{ $slot }}
</a>
