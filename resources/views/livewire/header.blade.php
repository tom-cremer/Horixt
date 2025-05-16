<div>
    <flux:header class="flex justify-end gap-5 px-0!">
        <livewire:partials.breadcrumb/>
        <div class="max-w-[500px] w-full">
            <flux:input
                wire:model="search"
                type="text"
                placeholder="{{ __('Search') }}"
            />
        </div>
        <livewire:partials.tracks.active-tracks/>
    </flux:header>
</div>
