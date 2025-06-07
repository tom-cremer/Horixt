<div>
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-2">

        @foreach($organizations as $organization)
            <div
                class="min-w-60 w-full min-h-36 p-4 bg-gray-100 rounded-2xl shadow
                hover:bg-gray-200 dark:bg-zinc-600 dark:hover:bg-zinc-700 transition duration-300
                ease-in-out cursor-pointer flex flex-col justify-between gap-2.5"
                wire:click="toOrganization({{ $organization->id }})"
                wire:navigate
                wire:key="organization-{{ $organization->id }}"
            >
                <div class="grid grid-cols-[auto_1fr] items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        {{substr($organization->name, 0, 1)}}
                    </div>
                    <div class="flex flex-col">
                        <flux:heading size="lg" class="mb-0! font-lexend">{{$organization->name}}</flux:heading>
                        <flux:subheading class="font-lexend">{{$organization->description}}</flux:subheading>
                    </div>
                </div>
                <flux:separator/>
                <div class="grid grid-cols-[1fr_auto_auto] gap-4">
                    <div class="flex flex-col gap-2">
                        <flux:text class="font-lexend font-medium">Team&nbsp;:</flux:text>
                        <div class="flex"> {{--Team bubbles--}}
                            <flux:avatar.group class="ring-0! ring-transparent!">
                                @php
                                    // Get active members of the organization
                                    $members = $organization->activeMembers;
                                   $members = $members->reject(function ($member) use ($organization) {
                                       return $member->id === $organization->owner_id;
                                   });
                                @endphp
                                @foreach($members->take(5) as $member)
                                    @if($member->avatar)
                                        <flux:avatar tooltip="{{$member->name}}" size="sm"
                                                     class="ring-0! ring-transparent!"
                                                     src="{{\Illuminate\Support\Facades\Storage::url($member->avatar->path)}}"/>
                                    @else
                                        <flux:avatar tooltip="{{$member->name}}" size="sm" name="{{$member->name}}"
                                                     class="ring-0! ring-transparent!"/>
                                    @endif
                                @endforeach
                                @if(count($members) >= 5)
                                    <flux:avatar>{{count($members) - 5}}+</flux:avatar>
                                @endif
                            </flux:avatar.group>
                        </div>
                    </div>
                    <flux:separator vertical/>
                    <div class="flex flex-col gap-2 justify-center">
                        <flux:text class="font-lexend font-medium">Owner&nbsp;:</flux:text>
                        <div class="flex items-center justify-center">
                            @if($organization->owner->avatar)
                                <flux:avatar tooltip="{{$organization->owner->name}}" size="sm"
                                             src="{{\Illuminate\Support\Facades\Storage::url($organization->owner->avatar->path)}}"/>
                            @else
                                <flux:avatar tooltip="{{$organization->owner->name}}" size="sm"
                                             name="{{$organization->owner->name}}"/>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        @endforeach

        <div wire:click="openAddOrganizationModal" wire:key="add-organization"
             class="cursor-pointer flex flex-col items-center justify-center gap-1.5 border-dashed border-2 border-gray-300 dark:border-zinc-500 hover:bg-gray-100 dark:hover:bg-zinc-700 transition-all duration-300 rounded-xl p-4">
            <div class="bg-[#7F76FF] rounded-md p-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="white" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14"/>
                    <path d="M12 5v14"/>
                </svg>
            </div>
            <flux:text variant='subtle' class="font-medium">
                Add Organization
            </flux:text>
        </div>
    </div>

    <flux:modal name="add-organization" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add Organization</flux:heading>
            </div>
            <flux:input label="Name" placeholder="Org Name" wire:model="name"/>
            <flux:input label="Slug" placeholder="Slug" wire:model="slug"/>


            <flux:input label="Description" placeholder="Description" wire:model="description"/>
            <flux:input label="Email" placeholder="Email" wire:model="email"/>
            <flux:input label="Website" placeholder="Website" wire:model="website"/>
            <flux:input label="Phone" placeholder="Phone" wire:model="phone"/>


            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" variant="primary" wire:click="createOrganization">Create Organization
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>
