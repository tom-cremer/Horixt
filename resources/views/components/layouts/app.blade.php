<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark min-h-screen">
<head>
    @include('partials.head')
</head>
<body class="relative min-h-screen bg-white dark:bg-zinc-800 grid grid-cols-[auto_1fr] grid-rows-1 font-lexend" style="overflow-x: hidden;">
@livewire('sidebar')
<main class="p-5 pt-0 h-screen flex flex-col w-full overflow-hidden">
    @livewire('header')
    <div class="flex flex-col gap-4 mt-2 overflow-y-auto row-start-2 row-end-3 h-full">
        {{ $slot }}
    </div>
</main>
<livewire:partials.feedback.toast/>
@fluxScripts
</body>
</html>
