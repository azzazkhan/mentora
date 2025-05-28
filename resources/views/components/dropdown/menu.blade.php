@props(['class' => null])
<div data-popover aria-hidden="true" x-bind="$content" class="{{ cn('min-w-56', $class) }}" {{ $attributes }}>
    <nav role="menu">
        {{ $slot }}
    </nav>
</div>
