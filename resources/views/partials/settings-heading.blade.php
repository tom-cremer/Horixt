<div class="relative mb-3 w-full ">
    <flux:heading size="xl" level="1" class="mb-2">{{ __('Settings') }}</flux:heading>
    {{--
        <flux:subheading size="lg" class="mb-3">{{ __('Manage your profile and account settings') }}</flux:subheading>
    --}}

    <div class="mr-10 max-w-48 pb-4 ">
        <flux:navlist class="flex sm:flex-row">
            <flux:navlist.item
                href="{{(\App\Helper\Context::isOrganization())? route('organization.settings.profile', ['slug' => \App\Helper\Context::getOrganizationSlug()]) : route('personal.settings.profile')}}"
                wire:navigate>
                {{ __('Profile') }}
            </flux:navlist.item>
            <flux:navlist.item
                href="{{(\App\Helper\Context::isOrganization())? route('organization.settings.password', ['slug' => \App\Helper\Context::getOrganizationSlug()]) : route('personal.settings.password')}}"
                wire:navigate>
                {{ __('Password') }}
            </flux:navlist.item>
            <flux:navlist.item
                href="{{(\App\Helper\Context::isOrganization())? route('organization.settings.preferences', ['slug' => \App\Helper\Context::getOrganizationSlug()]) : route('personal.settings.preferences')}}"
                wire:navigate>
                {{ __('Preferences') }}
            </flux:navlist.item>
            @if(\App\Helper\Context::isOrganization() && auth()->user()->can(\App\Enums\PermissionEnum::ORG_MANAGE))
                <flux:navlist.item
                    href="{{ route('organization.settings.org-settings', ['slug' => \App\Helper\Context::getOrganizationSlug()]) }}"
                    wire:navigate>
                    {{ __('Organization') }}
                </flux:navlist.item>
            @endif
        </flux:navlist>
    </div>

    <flux:separator variant="subtle"/>
</div>
