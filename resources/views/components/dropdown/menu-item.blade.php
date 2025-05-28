@props(['as' => 'button', 'type' => 'button', 'role' => 'menuitem', 'class' => null])
<{{ $as }} type="{{ $type }}" role="{{ $role }}" class="{{ cn('flex gap-x-2', $class) }}" {{ $attributes }}>
    {{ $slot }}
</{{ $as }}>
