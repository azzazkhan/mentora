<div role="group" aria-labelledby="account-options">
    @isset($heading)
        <span role="heading">{{ $heading }}</span>
    @endif

    {{ $slot }}
</div>
