<div class="flex flex-col items-start w-full h-full overflow-y-auto">

    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Organization')" :subheading="__('Update current organization settings')">
        <div class="mx-2 flex flex-col gap-6">
            <form class="my-6 mx-2 w-full max-w-xl space-y-6" wire:submit.prevent="update">


                {{--Organization Name--}}
                <div class="flex flex-col gap-3 max-w-96">
                    <flux:heading level="3">{{ __('Organization Name') }}</flux:heading>
                    <flux:input
                        wire:model="name"
                        size="sm"
                        placeholder="{{ __('Enter organization name') }}"
                        required
                    />
                </div>
                <div class="flex flex-col gap-3 max-w-96">
                    <flux:heading level="3">{{ __('Slug') }}</flux:heading>
                    <flux:input
                        wire:model="slug"
                        size="sm"
                        placeholder="{{ __('Enter organization slug') }}"
                        required
                    />
                </div>

                <div class="flex flex-col gap-3 max-w-96">
                    <flux:input type="file" wire:model="avatar" label="Avatar"/>

                    @if ($organization->avatar)
                        <div class="mb-4 flex items-center gap-4">
                            <flux:avatar size="xl"
                                         src="{{\Illuminate\Support\Facades\Storage::url($organization->avatar->path)}}"/>
                            <flux:button variant="danger" type="button" size="sm" wire:click="deleteAvatar">Delete
                                Avatar
                            </flux:button>
                        </div>
                    @else
                        <div class="mb-4 flex items-center gap-4">
                            <flux:avatar size="xl" initials="{{$organization->initials()}}"/>
                            <flux:text class="text-zinc-500 dark:text-zinc-400">
                                {{ __('No avatar set. Upload one to personalize your profile.') }}
                            </flux:text>
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>


            <flux:separator/>

            {{--Status and Priority Colors--}}
            <div class="flex flex-col gap-4">
                <flux:heading level="3" size="lg">Colors Personalization</flux:heading>
                <div class="grid grid-cols-1 sm:grid-cols-[1fr_auto_1fr] max-w-2xl gap-6">
                    {{--Status color--}}
                    <div class="flex flex-col gap-3">
                        <flux:heading level="3">Statuses</flux:heading>
                        <div
                            class="flex flex-col gap-2">
                            @foreach($statuses as $status)
                                <div x-data="{ editStatus: false }"
                                     class="relative grid grid-cols-[1fr_auto] gap-2">
                                    <flux:badge :color="$status->organizationStatusColor->color->alias"
                                                class="w-fit">{{ $status->name }} </flux:badge>
                                    <div class="relative">

                                        <button x-on:click="editStatus = !editStatus"
                                                class="mr-1.5 p-0.5 w-8 h-6 rounded-md border border-zinc-300 dark:border-zinc-600
                                            focus:outline-none focus:ring-2 focus:ring-zinc-800 dark:focus:ring-zinc-100">
                                <span
                                    class="block {{$status->organizationStatusColor->color->alias}} w-full h-full rounded-sm"> </span>
                                        </button>
                                        <div x-show="editStatus"
                                             @click.away="editStatus = false"
                                             class="absolute top-full right-full grid grid-cols-4 items-center justify-center gap-2 bg-zinc-100 dark:bg-zinc-700 p-2 rounded-md z-10 shadow-md min-w-32">
                                            @foreach($colors as $color)
                                                <button
                                                    wire:click="updateStatusColor({{ $status->id }}, {{ $color->id }})"
                                                    class="w-6 h-6 rounded-full {{ $color->alias }} focus:ring-2 ring-offset-2 ring-zinc-500"
                                                    title="{{ $color->name }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <flux:separator vertical class="hidden sm:block"/>
                    <flux:separator class="block sm:hidden"/>
                    {{--Priority color--}}
                    <div class="flex flex-col gap-3">
                        <flux:heading level="3">Priorities</flux:heading>
                        <div
                            class="flex flex-col gap-2">
                            @foreach($priorities as $priority)

                                <div x-data="{ editPriority: false }"
                                     class="relative grid grid-cols-[1fr_auto] gap-2">
                                    <flux:badge :color="$priority->organizationPriorityColor->color->alias"
                                                class="w-fit">{{ $priority->name }} </flux:badge>
                                    <div class="relative">

                                        <button x-on:click="editPriority = !editPriority"
                                                class="mr-1.5 p-0.5 w-8 h-6 rounded-md border border-zinc-300 dark:border-zinc-600
                                    focus:outline-none focus:ring-2 focus:ring-zinc-800 dark:focus:ring-zinc-100">
                                    <span
                                        class="block {{$priority->organizationPriorityColor->color->alias}} w-full h-full rounded-sm"> </span>
                                        </button>
                                        <div x-show="editPriority"
                                             @click.away="editPriority = false"
                                             class="absolute top-full right-full grid grid-cols-4 items-center justify-center gap-2 bg-zinc-100 dark:bg-zinc-700 p-2 rounded-md z-10 shadow-md min-w-32">
                                            @foreach($colors as $color)
                                                <button
                                                    wire:click="updatePriorityColor({{ $priority->id }}, {{ $color->id }})"
                                                    class="w-6 h-6 rounded-full {{ $color->alias }} focus:ring-2 ring-offset-2 ring-zinc-500"
                                                    title="{{ $color->name }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="min-h-40"></div>
        </div>
    </x-settings.layout>
</div>
