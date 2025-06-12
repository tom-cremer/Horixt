<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')

</head>
<body
    class="bg-[#FDFDFC]  dark:bg-zinc-800 text-[#1b1b18] flex flex-col   pt-4  lg:pt-5 min-h-screen font-lexend max-w-6xl mx-auto">


<section
    class="relative h-screen max-h-[1024px] flex flex-col items-center px-6 bg-[#FDFDFC] dark:bg-zinc-800 overflow-hidden">
    <header
        class="flex items-center justify-between w-full text-sm lg:max-w-6xl mx-auto not-has-[nav]:hidden">
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

    <!-- Floating Side Components -->
    <div class="absolute top-1/4 left-10 lg:block hidden animate-[float_4s_ease-in-out_infinite]  z-10">
        <div
            class="bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 p-4 rounded-xl shadow-md text-xs text-gray-500 w-40">
            <flux:text variant="strong">⏱️ Time Tracker</flux:text>
        </div>
    </div>
    <div
        class="absolute bottom-1/2 right-6 lg:block hidden animate-float-fast animate-[float_5s_ease-in-out_infinite] z-10">
        <div
            class="bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 p-4 rounded-xl shadow-md text-xs text-gray-500 w-40">
            <flux:text variant="strong">📁 Files Manager</flux:text>
        </div>
    </div>
    <div
        class="absolute top-3/4 left-2 lg:block hidden animate-float-fast animate-[float_6s_ease-in-out_infinite] z-10">
        <div
            class="bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 p-4 rounded-xl shadow-md text-xs text-gray-500 w-40">
            <flux:text variant="strong">✅ Task manager</flux:text>
        </div>
    </div>

    <!-- Centered Hero Content -->
    <div class="max-w-lg text-center relative z-10 flex flex-col items-center mt-24">
        <flux:badge color="yellow" variant="pill">
            🚀 Built for teams & freelancers
        </flux:badge>
        <h1 class="text-4xl md:text-5xl font-bold leading-tight text-zinc-800 dark:text-white ">
            Organize your work with <b
                class="text-[#7F76FF] dark:text-[#7F76FF] font-extrabold">{{config('app.name')}}</b>
        </h1>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 text-balance mt-3 mb-4">
            Tasks. Time. Files. Everything your team needs — all in one.
        </p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-[#7F76FF] text-white rounded-xl shadow hover:bg-[#675CFF] font-semibold transition">
                Get Started
            </a>
            <a href="#features"
               class="px-6 py-3 border border-gray-300 dark:border-zinc-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-100 dark:hover:bg-zinc-800 transition">
                Learn More
            </a>
        </div>
    </div>

    <!-- Dashboard Preview -->
    <div
        class="mt-auto relative w-full max-w-5xl overflow-hidden max-h-1/2 z-0 opacity-30 dark:opacity-20 pointer-events-none ">
        <!-- Desktop Screen -->
        <div class="hidden md:block rounded-3xl overflow-hidden border border-gray-200 dark:border-zinc-800">
            <img src="https://placehold.co/800x500" alt="{{config('app.name')}} Dashboard Preview - Desktop"
                 class="w-full">
        </div>
        <!-- Tablet Screen -->
        <div class="hidden sm:block md:hidden rounded-3xl overflow-hidden border border-gray-200 dark:border-zinc-800">
            <img src="https://placehold.co/700x900" alt="{{config('app.name')}} Dashboard Preview - Tablet"
                 class="w-full object-cover">
        </div>
        <!-- Smartphone Screen -->
        <div class="block sm:hidden rounded-3xl overflow-hidden border border-gray-200 dark:border-zinc-800">
            <img src="https://placehold.co/400x600" alt="{{config('app.name')}} Dashboard Preview - Smartphone"
                 class="w-full object-cover">
        </div>
    </div>
</section>

<section class="relative py-6 text-white text-center isolate shadow-lg rounded-xl">
    <!-- Gradient background -->
    <div
        class="absolute rounded-xl inset-0 bg-[linear-gradient(90deg,_#8b67f8,_#654aff,_#3935ff)] animate-gradient-x z-0"></div>

    <div class="relative z-20 px-4">
        <p class="text-xl md:text-2xl font-semibold ">
            Ready to transform your workflow?
        </p>
    </div>
</section>


<!-- Features Section -->
<section id="features" class="py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <h2 class="text-4xl font-bold text-center text-zinc-900 dark:text-white mb-16">
            Built for <span class="text-[#7F76FF]">every step</span> of your workflow
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-[#f7f7f5] dark:bg-zinc-700 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">🧠 Tasks & Planning</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">Structure work the way your brain works — with
                    nesting, statuses, and priorities.</p>
            </div>
            <div class="bg-[#EAE8FF] p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-900 mb-2">⏱ Time Tracking</h3>
                <p class="text-sm text-zinc-700">Track real hours on real work. Integrated into every to-do for accuracy
                    you can trust.</p>
            </div>
            <div class="bg-[#f7f7f5] dark:bg-zinc-700 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">📁 Smart File Management</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">Store, preview, and lock files — with version
                    control and granular access.</p>
            </div>
            <div class="bg-[#D7F8E4] p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-zinc-900 mb-2">🧩 Modular Features</h3>
                <p class="text-sm text-zinc-800">Choose what you need, nothing more. Notes, clients, calendar — à la
                    carte.</p>
            </div>
            <div class="bg-[#f7f7f5] dark:bg-zinc-700 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">🧑‍💼 Organizations</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">Built for teams. Manage roles, invite clients, and
                    keep control over your structure.</p>
            </div>
            <div class="bg-[#FFE9E2] p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-zinc-900 mb-2">📊 Project Insights</h3>
                <p class="text-sm text-zinc-800">Know where your time goes. Analyze by task, team, or project in a
                    click.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 relative bg-[#FDFDFC] dark:bg-zinc-700 rounded-4xl overflow-hidden">


    <div class="max-w-6xl mx-auto px-10 flex flex-col lg:flex-row items-center gap-12">
        <div class="flex-1 space-y-6">
            <h2 class="text-3xl md:text-4xl font-extrabold text-zinc-800 dark:text-white">
                One space. Every workflow.
            </h2>
            <p class="text-lg text-zinc-600 dark:text-zinc-400">
                Create, assign, track, and deliver — without switching tabs. {{config('app.name')}} adapts to your
                rhythm.
            </p>
            <ul class="space-y-3">
                <li class="flex items-center gap-3">
                    <span class="text-[#7F76FF]">✓</span>
                    <flux:text>Nestable tasks with timelines</flux:text>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#7F76FF]">✓</span>
                    <flux:text>Time tracking integrated at every level</flux:text>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#7F76FF]">✓</span>
                    <flux:text>Insights that go beyond timesheets</flux:text>
                </li>
            </ul>
        </div>

        <div class="flex-1">
            <div class="rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl">
                <img src="https://placehold.co/300x250" alt="Dashboard Demo" class="w-full">
            </div>
        </div>
    </div>
</section>


<section class="py-24  text-white text-center">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-6 dark:text-white text-zinc-800">Time to work smarter, not harder</h2>
        <p class="text-lg md:text-xl mb-8 dark:text-white text-zinc-800">
            Whether you're solo or scaling your team — {{config('app.name')}} is built to adapt, grow, and simplify your
            process.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-[#7F76FF] text-white rounded-xl shadow hover:bg-[#675CFF] font-semibold transition">
                Get Started
            </a>
        </div>
    </div>
</section>


<!-- Footer -->
<footer class="flex flex-col items-center gap-10 w-full min-h-24">
    <div
        class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full bg-[#FDFDFC] dark:bg-zinc-800 border-t border-zinc-200 dark:border-zinc-600 py-4 px-6 lg:px-12 min-h-72">
        <div class="flex flex-col items-start justify-between space-y-4">
            <div class="flex flex-col items-center space-y-1">
                <p  class="text-xl dark:text-white text-zinc-800 font-semibold">
                    This project is not an end,<br/>
                    but a starting point.
                </p>

            </div>
            <div class="flex flex-col items-center space-y-1">
                <flux:text variant="subtle" class="">
                    Socials coming soon!
                </flux:text>
            </div>
            <div class="flex flex-col items-start space-y-1">
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">
                    Built with ❤️ by Tom Cremer.
                </flux:text>
                <flux:text class="mb-1">&copy; {{ date('Y') }} {{config('app.name')}} — All rights reserved.</flux:text>
            </div>

        </div>
        <div
            class="max-w-6xl flex flex-col justify-start md:justify-center md:items-center gap-5 text-sm text-zinc-600 dark:text-zinc-400">

                <div class="flex flex-col gap-1">
                    <flux:text variant="strong">
                        Contact us:
                    </flux:text>
                    <a href="mailto:contact@horixt.com" class="hover:text
                    text-[#7F76FF] dark:text-[#7F76FF] transition">contact@horixt.com</a>
                </div>

        </div>
    </div>

    <div class="w-full">
        <svg viewBox="0 0 98 27" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path class="transform translate-y-[1px]"
                d="M15.024 26V3.6H19.824V26H15.024ZM0.912 26V3.6H5.712V26H0.912ZM2.832 17.008L2.864 12.656H17.488V17.008H2.832ZM32.894 26.32C31.166 26.32 29.6193 25.9467 28.254 25.2C26.91 24.432 25.8433 23.3867 25.054 22.064C24.286 20.7413 23.902 19.2267 23.902 17.52C23.902 15.8133 24.286 14.2987 25.054 12.976C25.8433 11.6533 26.91 10.6187 28.254 9.872C29.6193 9.104 31.166 8.72 32.894 8.72C34.6007 8.72 36.126 9.104 37.47 9.872C38.8353 10.6187 39.902 11.6533 40.67 12.976C41.438 14.2987 41.822 15.8133 41.822 17.52C41.822 19.2267 41.438 20.7413 40.67 22.064C39.902 23.3867 38.8353 24.432 37.47 25.2C36.126 25.9467 34.6007 26.32 32.894 26.32ZM32.894 22.352C33.726 22.352 34.4727 22.1493 35.134 21.744C35.7953 21.3173 36.3073 20.7413 36.67 20.016C37.054 19.2693 37.2353 18.4373 37.214 17.52C37.2353 16.5813 37.054 15.7493 36.67 15.024C36.3073 14.2773 35.7953 13.7013 35.134 13.296C34.4727 12.8693 33.726 12.656 32.894 12.656C32.0407 12.656 31.2833 12.8693 30.622 13.296C29.9607 13.7227 29.438 14.2987 29.054 15.024C28.67 15.7493 28.4887 16.5813 28.51 17.52C28.4887 18.4373 28.67 19.2693 29.054 20.016C29.438 20.7413 29.9607 21.3173 30.622 21.744C31.2833 22.1493 32.0407 22.352 32.894 22.352ZM45.272 26V9.072H49.656L49.816 14.512L49.048 13.392C49.304 12.5173 49.72 11.728 50.296 11.024C50.872 10.2987 51.544 9.73333 52.312 9.328C53.1013 8.92267 53.9227 8.72 54.776 8.72C55.1387 8.72 55.4907 8.752 55.832 8.816C56.1733 8.88 56.4613 8.95467 56.696 9.04L55.48 14.032C55.2453 13.904 54.936 13.7973 54.552 13.712C54.1893 13.6053 53.816 13.552 53.432 13.552C52.92 13.552 52.44 13.648 51.992 13.84C51.5653 14.0107 51.192 14.2667 50.872 14.608C50.552 14.928 50.296 15.312 50.104 15.76C49.9333 16.208 49.848 16.6987 49.848 17.232V26H45.272ZM59.6873 26V9.072H64.2313V26H59.6873ZM61.9273 5.616C61.0526 5.616 60.3699 5.40267 59.8793 4.976C59.3886 4.528 59.1432 3.90933 59.1432 3.12C59.1432 2.39467 59.3886 1.808 59.8793 1.36C60.3913 0.890665 61.0739 0.655998 61.9273 0.655998C62.8019 0.655998 63.4846 0.879999 63.9753 1.328C64.4659 1.75467 64.7113 2.352 64.7113 3.12C64.7113 3.84533 64.4553 4.44267 63.9433 4.912C63.4526 5.38133 62.7806 5.616 61.9273 5.616ZM79.7725 26L75.5805 20.016L74.3005 18.224L67.4525 9.072H72.9565L77.0525 14.864L78.4605 16.752L85.2125 26H79.7725ZM67.3885 26L74.1405 16.752L76.6365 19.728L72.7325 26H67.3885ZM78.2685 18.384L75.8365 15.408L79.4525 9.072H84.7965L78.2685 18.384ZM89.654 26V4.784H94.198V26H89.654ZM86.486 13.136V9.072H97.686V13.136H86.486Z"
                fill="#7F76FF"/>
        </svg>
    </div>

</footer>

@fluxScripts()
</body>
</html>
