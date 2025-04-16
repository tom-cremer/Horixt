<div>
    <flux:header class="flex justify-end gap-5">
        <div class="w-full max-w-[500px]">
            <flux:input
                wire:model="search"
                type="text"
                placeholder="{{ __('Search') }}"
            />
        </div>
        @if (\App\Helper\Context::isPersonal())
            <flux:modal.trigger name="create-organization">
                <flux:button
                    variant="primary"
                    aria-label="{{ __('Create new') }}"
                >
                    Create Organization
                </flux:button>
            </flux:modal.trigger>
        @endif
    </flux:header>

    <flux:modal name="create-organization">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create Organization</flux:heading>
                <flux:subheading>Fill in the details below to create a new organization.</flux:subheading>
            </div>

            <flux:input
                wire:model="name"
                type="text"
                placeholder="{{ __('Organization Name') }}"
                required
            />

            <flux:input
                wire:model="description"
                type="textarea"
                placeholder="{{ __('Description') }}"
                required
            />

            <flux:input
                wire:model="email"
                type="email"
                placeholder="{{ __('Email') }}"
                required
            />

            <flux:input
                wire:model="website"
                type="url"
                placeholder="{{ __('Website') }}"
                required
            />

            <flux:input
                wire:model="phone"
                type="tel"
                placeholder="{{ __('Phone') }}"
                required
            />

            <div class="flex">
                <flux:spacer/>
                <flux:button
                    variant="primary"
                    type="submit"
                    wire:click="createOrganization">
                    {{ __('Create') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>
