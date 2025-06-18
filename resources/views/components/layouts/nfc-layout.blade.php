<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark min-h-screen">
<head>
    @include('partials.head')
</head>
<body
    class="bg-[#FDFDFC]  dark:bg-zinc-800 text-[#1b1b18] flex flex-col  min-h-screen font-lexend">
{{ $slot }}

@fluxScripts
</body>
</html>
