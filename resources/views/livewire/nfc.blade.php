<div class="min-h-screen bg-gradient-to-br from-[#1a1a1d] via-[#2b2b30] to-[#1a1a1d] overflow-x-hidden"
     x-data="$flux.dark = true">

    <header
        class="mt-4 px-4 sm:px-3 xl:px-0.5 flex items-center justify-between w-full text-sm lg:max-w-6xl mx-auto not-has-[nav]:hidden">
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
                <flux:button size="sm" icon="download" variant="ghost" wire:click="downloadBadge"/>
            </nav>
        @endif
    </header>

    <section class="mt-16 sm:mt-20 md:mt-28 text-white flex items-center justify-center px-4">
        <div class="wrapper w-full max-w-4xl mx-auto text-center">
            <div class="relative flex flex-col items-center justify-center gap-8 ">
                <div class="absolute w-[300px] h-[300px] rounded-full bg-purple-500 opacity-30 blur-2xl move-one"></div>
                <div class="absolute w-[320px] h-[320px] rounded-full bg-pink-500 opacity-30 blur-2xl move-two"></div>
                <div
                    class="absolute w-[270px] h-[270px] rounded-full bg-indigo-500 opacity-30 blur-2xl move-three"></div>

                <div
                    x-data="{
                    show: false,
                    init() {
                        window.addEventListener('load', () => {
                            setTimeout(() => {
                                this.show = true;
                            }, 500);
                        });
                    }
                }"
                    x-init="init()"
                    x-show="show"
                    x-cloak
                    :class="{ 'animate-badge': show }"
                    class="relative z-10 min-h-[320px] transition-all"
                >
                    <div class="relative group perspective-1000">
                        <img
                            src="{{ Storage::disk('local')->temporaryUrl('badges/' . $badge->dark_badge_image, now()->addMinutes(5)) }}"
                            alt="Badge NFC Horixt"
                            class="w-80 rounded-xl shadow-2xl"
                        >

                        <div class="absolute inset-0 rounded-xl pointer-events-none overflow-hidden">
                            <div
                                class="absolute top-0 left-[-75%] w-[50%] h-full bg-white opacity-10 rotate-12 animate-gloss"></div>
                        </div>
                    </div>
                </div>

                <!-- Texte -->
                <div class="text-center mt-8">
                    <h1 class="text-3xl md:text-5xl font-bold font-display">Prêts à vivre une aventure&nbsp;?</h1>
                    <p class="mt-2 text-lg opacity-70">Plongez dans l'univers d'{{config('app.name')}}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-32 relative text-white px-4">
        <div class="wrapper w-full max-w-6xl mx-auto text-center">
            <h2 class="text-4xl font-display font-bold">Ce que vous pouvez faire avec Horixt</h2>
            <p class="mt-2 text-lg text-white/60">Une suite d’outils modulaires, conçus pour vous faire gagner du
                temps.</p>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white/5 rounded-xl p-6 backdrop-blur hover:bg-white/10 transition">
                    <h3 class="text-xl font-semibold">Gérer vos tâches</h3>
                    <p class="text-white/60 mt-2 text-sm">Des to-dos imbriqués, assignables, avec des commentaires et
                        des suivis de temps intégrés.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 backdrop-blur hover:bg-white/10 transition">
                    <h3 class="text-xl font-semibold">Organiser vos projets</h3>
                    <p class="text-white/60 mt-2 text-sm">Suivi de projet visuel, statuts personnalisés, membres et
                        clients liés.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 backdrop-blur hover:bg-white/10 transition">
                    <h3 class="text-xl font-semibold">Partager des fichiers</h3>
                    <p class="text-white/60 mt-2 text-sm">Un gestionnaire de fichiers sécurisé, lié à vos tâches,
                        projets ou notes.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 backdrop-blur hover:bg-white/10 transition">
                    <h3 class="text-xl font-semibold">Suivre le temps</h3>
                    <p class="text-white/60 mt-2 text-sm">Activez un timer sur une tâche, obtenez des stats, gérez vos
                        forfaits client.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 backdrop-blur hover:bg-white/10 transition">
                    <h3 class="text-xl font-semibold">Prendre des notes</h3>
                    <p class="text-white/60 mt-2 text-sm">Notes liées, post-it, annotations rapides sur les projets en
                        cours.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 backdrop-blur hover:bg-white/10 transition">
                    <h3 class="text-xl font-semibold">Tout centraliser</h3>
                    <p class="text-white/60 mt-2 text-sm">Un tableau de bord par organisation ou personnel, pour tout
                        voir en un coup d’œil.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-32 relative text-white px-4">
        <div class="wrapper w-full max-w-5xl mx-auto text-center">
            <h2 class="text-4xl font-display font-bold">Une interface fluide et intuitive</h2>
            <p class="mt-2 text-lg text-white/60">Conçue pour vous laisser travailler sans friction.</p>

            <div class="relative mt-16 overflow-hidden rounded-2xl shadow-2xl border border-white/10">
                <video
                    class="w-full"
                    autoplay muted loop playsinline
                    src="/videos/horixt-overview.mp4"
                ></video>
                <!-- ou une image mockup -->
                <!-- <img src="/images/horixt-dashboard-preview.png" alt="Horixt Dashboard" class="w-full"> -->
            </div>
        </div>
    </section>

    <section class="mt-32 relative text-white px-4">
        <div class="wrapper w-full max-w-5xl mx-auto text-center">
            <h2 class="text-4xl font-display font-bold">Pour les indépendants, les équipes, les organisations</h2>
            <p class="mt-2 text-lg text-white/60">Horixt s’adapte à votre échelle.</p>

            <div class="mt-12 flex flex-col md:flex-row justify-center gap-8 text-left">
                <div class="bg-white/5 rounded-xl p-6 w-full md:w-1/3 backdrop-blur">
                    <h3 class="text-xl font-semibold">Mode Solo</h3>
                    <p class="text-white/60 mt-2 text-sm">Gratuit, privé, tout est stocké chez vous. Pour vos projets
                        persos ou freelances.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 w-full md:w-1/3 backdrop-blur">
                    <h3 class="text-xl font-semibold">Petites équipes</h3>
                    <p class="text-white/60 mt-2 text-sm">Collaboration en temps réel, partage de fichiers, suivi simple
                        des projets.</p>
                </div>
                <div class="bg-white/5 rounded-xl p-6 w-full md:w-1/3 backdrop-blur">
                    <h3 class="text-xl font-semibold">Organisations</h3>
                    <p class="text-white/60 mt-2 text-sm">Gestion des rôles, espace sécurisé, statistiques et connexion
                        client.</p>
                </div>
            </div>
        </div>
    </section>
    <footer class="mt-38 ">
        <div class="wrapper flex flex-col items-center gap-10 min-h-24">

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full  border-t border-zinc-200 dark:border-zinc-600 py-4 px-6 lg:px-12 min-h-72">
                <div class="flex flex-col items-start justify-between space-y-4">
                    <div class="flex flex-col items-center space-y-1">
                        <p class="text-xl dark:text-white text-zinc-800 font-semibold">
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
                        <flux:text class="mb-1">&copy; {{ date('Y') }} {{config('app.name')}} — All rights reserved.
                        </flux:text>
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
        </div>

    </footer>

    <flux:modal name="downloadBadgeModal" class="max-w-96">
        <h2 class="text-xl font-bold mb-5">Télécharger votre badge</h2>
        <div class="grid grid-cols-1 gap-6">

            <div class="flex flex-col items-center justify-center gap-4">
                @if(!$selectedBadge)

                    <img
                        src="{{ Storage::disk('local')->temporaryUrl('badges/' . $badge->dark_badge_image, now()->addMinutes(5)) }}"
                        alt="Badge NFC Horixt"
                        class="w-72 rounded-xl shadow-2xl"
                    >
                @else
                    <img
                        src="{{ Storage::disk('local')->temporaryUrl('badges/' . $badge->light_badge_image, now()->addMinutes(5)) }}"
                        alt="Badge NFC Horixt"
                        class="w-72 rounded-xl shadow-2xl"
                    >
                @endif

            </div>
            <div class="flex flex-col items-center justify-center gap-4">
                <flux:switch label="Changer le thème" align="left" wire:model.live="selectedBadge"/>
                <flux:button icon="download" variant="primary" wire:click="startDownloadBadge">
                    Télécharger
                </flux:button>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Votre badge sera téléchargé au format PNG.
                </p>
            </div>
        </div>
    </flux:modal>

</div>
