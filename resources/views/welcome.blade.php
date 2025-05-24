<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')

</head>
<body
    class="bg-[#FDFDFC] dark:bg-zinc-800 text-[#1b1b18] flex p-6 lg:p-8 min-h-screen font-lexend">
<section class="w-full h-full">
    <div class="relative w-full h-full flex flex-col items-center justify-center">
        <header
            class="flex items-center justify-between w-full text-sm mb-6 lg:max-w-6xl m-auto not-has-[nav]:hidden">
            <a
                href="/"
                title="{{config('app.name')}}"
                class="flex items-center gap-2">
                <x-app-logo-icon/>
                <flux:heading level="1" size="xl" class="font-bold!">{{config('app.name')}}</flux:heading>
            </a>
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ route('personal.dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="whitespace-nowrap inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                    <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                                 aria-label="Toggle dark mode"/>
                </nav>
            @endif
        </header>
        <div class="min-h-[70vh] max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Left Content -->
            <div class="space-y-4">
                <flux:badge color="yellow" variant="pill">
                    🚀 Built for teams & freelancers
                </flux:badge>
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight  text-neutral-800 dark:text-white max-w-md sm:max-w-sm ">
                    Organize your work with <b class="text-[#5844ff] dark:text-[#5844ff]">Horixt</b>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Plan, track, and collaborate effortlessly — all in one smart workspace.
                </p>
                <div class="flex gap-4 flex-col sm:flex-row">
                    <a href="{{route('register')}}" class="inline-block w-fit px-6 py-3 text-white bg-[#5844ff] hover:bg-[#4733FF] font-semibold rounded-xl shadow transition-colors duration-200">
                        Get Started
                    </a>
                    <flux:spacer/>
                    {{--<a href="#demo" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-400 dark:border-gray-600 text-gray-800 dark:text-white hover:border-white rounded-xl transition">
                        ▶ Watch Demo
                    </a>--}}
                </div>
            </div>

            <!-- Right Image or Lottie Placeholder -->
            <div class="flex justify-center">
                {{--<img src="/images/mascot-placeholder.svg" alt="Hero Mascot" class="w-80 md:w-96 dark:brightness-90">--}}
            </div>
        </div>

       {{-- @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif--}}
    </div>

</section>
@fluxScripts()
</body>
</html>
