<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark min-h-screen">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 flex flex-col items-center justify-center" style="overflow-x: hidden;">
{{$slot}}
@fluxScripts
</body>
</html>
