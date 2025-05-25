<?php

$app_name = config('app.name', 'Laravel');
$pageTitle = isset($title) ? "{$title} &mdash; {$app_name}" : $app_name;

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ str($pageTitle)->toHtmlString() }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Ancizar+Serif:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet" />

        @livewireStyles
        @vite('resources/css/tailwind.css')
    </head>
    <body class="bg-background font-sans antialiased">
        <div class="min-h-dvh flex items-stretch">
            <x-layouts.app.sidebar />

            <div class="flex-grow">
                <header class="flex items-center justify-between h-20 px-10">
                    <div class="flex items-center gap-x-6">
                        <x-layouts.app.header.nav-item active>
                            <x-heroicon-s-squares-2x2 class="size-5" />
                            <span>Dashboard</span>
                        </x-layouts.app.header.nav-item>

                        <x-layouts.app.header.nav-item>
                            <x-heroicon-s-globe-alt class="size-5" />
                            <span>Browse</span>
                        </x-layouts.app.header.nav-item>

                        <x-layouts.app.header.nav-item>
                            <x-heroicon-s-chart-bar class="size-5" />
                            <span>Activity</span>
                        </x-layouts.app.header.nav-item>
                    </div>
                </header>

                <main class="py-20 px-10">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
