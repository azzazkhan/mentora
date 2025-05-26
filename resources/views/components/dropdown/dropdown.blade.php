@props(['class' => null])
<div class="{{ cn('popover', $class) }}" x-data="dropdownMenu" x-on:click.away="open = false" {{ $attributes }}>
    {{ $slot }}
</div>
