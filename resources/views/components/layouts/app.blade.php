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

        @livewireStyles
        @vite('resource/css/tailwind.css')
    </head>
    <body class="font-sans antialiased">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
