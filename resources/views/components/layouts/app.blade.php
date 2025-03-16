<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark min-h-screen">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 grid grid-cols-[auto_1fr] grid-rows-1" style="overflow-x: hidden;">
@livewire('sidebar')
<main class="p-5 overflow-y-auto h-screen ">
    {{ $slot }}
</main>

@fluxScripts
</body>
</html>
