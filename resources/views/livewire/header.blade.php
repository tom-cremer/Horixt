<div>
    <flux:header class="flex justify-end gap-3.5 px-0!">
        <livewire:partials.breadcrumb/>
        <livewire:partials.search/>
        <div class="flex items-center gap-2">
            <flux:dropdown x-data align="end" position="bottom" class="hidden sm:block">
                <flux:button variant="subtle" square class="group" size="sm" aria-label="Preferred color scheme">
                    <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini"
                                   class="text-zinc-500 dark:text-white"/>
                    <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini"
                                    class="text-zinc-500 dark:text-white"/>
                    <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini"/>
                    <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini"/>
                </flux:button>

                <flux:menu>
                    <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                    <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                    <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
            <livewire:partials.tracks.active-tracks/>
        </div>
    </flux:header>
</div>
