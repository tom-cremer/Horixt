<div>
    <flux:header class="flex flex-row! justify-end gap-3.5 px-0! relative z-40">
        <livewire:partials.breadcrumb/>
        <livewire:partials.search/>
        <div class="flex items-center gap-2">
            <livewire:partials.notifications/>
            <div>
                <flux:button x-data size="sm" x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                             aria-label="Toggle dark mode"/>
            </div>
            <livewire:partials.tracks.active-tracks/>
        </div>
    </flux:header>
</div>
