<div class="font-lexend h-full flex flex-col ">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Members</h2>
        @can(\App\Enums\PermissionEnum::ORG_MANAGE->value)
            <livewire:partials.add-members/>
        @endcan
    </div>


    <div class=" overflow-auto h-full">
        <table class="min-w-full  shadow overflow-auto border border-zinc-300 dark:border-zinc-600 ">
            <thead class=" text-left text-sm font-medium text-gray-700">
            <tr class="border-b border-zinc-300 dark:border-zinc-600">
                <th class="px-4 py-3 text-black dark:text-white  ">Name</th>
                <th class="px-4 py-3 text-black dark:text-white">Email</th>
                <th class="px-4 py-3 text-black dark:text-white">Role</th>
                <th class="px-4 py-3 text-black dark:text-white">Status</th>
                <th class="px-4 py-3 text-black dark:text-white">Joined</th>
                <th class="px-4 py-3 text-black dark:text-white text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
            @forelse ($this->members as $member)
                <tr class="border-b border-zinc-300 dark:border-zinc-600">
                    <td class=" px-4 py-3  border-r border-zinc-300 dark:border-zinc-600">
                        <div class="flex flex-nowrap items-center gap-2">

                            @if($member->avatar)
                                <flux:avatar tooltip="{{$member->name}}" size="xs"
                                             class="ring-0! ring-transparent!"
                                             src="{{\Illuminate\Support\Facades\Storage::url($member->avatar->path)}}"/>
                            @else
                                <flux:avatar tooltip="{{$member->name}}" size="xs"
                                             name="{{$member->name}}"
                                             class="ring-0! ring-transparent!²"
                                             color="auto"
                                             color:seed="{{ $member->id }}"
                                             initials:single/>
                            @endif

                            <span class="whitespace-nowrap truncate">{{ $member->name }}</span>

                            @if ($member->isOwner(\App\Helper\Context::getOrganizationId()))
                                <flux:badge color="green" size="sm">Owner</flux:badge>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600">
                        {{ $member->email }}
                    </td>
                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600">

                        <div x-data="{ memberRoles: false }"

                             class="relative w-full h-full
                            grid grid-cols-[1fr_auto] gap-1.5 items-center"
                        >
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($member->roles as $role)
                                    <flux:badge color="{{\App\Enums\RoleEnum::from($role->name)->color()}}"
                                                size="sm">{{ ucfirst($role->name) }}</flux:badge>
                                @empty
                                    <flux:text>No role</flux:text>
                                @endforelse
                            </div>
                            @if( auth()->user()->can(\App\Enums\PermissionEnum::ADMIN_MANAGE->value))

                                <flux:button square icon="user-round-cog" size="xs" variant="subtle"
                                             x-on:click="memberRoles = true" class="cursor-pointer"
                                />
                                <!--Modal-->
                                <div x-show="memberRoles" x-on:click.away="memberRoles = false"
                                     class="absolute bg-white dark:bg-zinc-700 top-10 right-0 rounded-lg shadow-md border border-zinc-200 dark:border-zinc-500
                                 grid grid-cols-1 grid-rows-[repeat(4,minmax(auto,1fr)] gap-1.5 p-2.5 min-w-64 max-w-72 min-h-56  z-50"
                                >
                                    <div>
                                        <flux:input
                                            wire:model.live="search"
                                            wire:keydown.enter.prevent="searchRole"
                                            icon="magnifying-glass"
                                            placeholder="Search"
                                            clearable
                                            size="sm"
                                        />

                                        <div class="overflow-y-auto max-h-36 my-2">
                                            <div class="flex flex-wrap gap-1.5 mt-2">
                                                @foreach(collect($searchResults)->reject(
                                                    fn($result) => $member->roles->contains('id', $result->id)
                                                    ) as $result)
                                                    <flux:badge
                                                        color="{{\App\Enums\RoleEnum::from($result->name)->color()}}"
                                                        size="sm">{{ ucfirst($result->name) }}</flux:badge>
                                                @endforeach
                                            </div>
                                        </div>

                                        <flux:separator/>
                                    </div>
                                    <div class="flex flex-col gap-2.5">
                                        <div class="flex flex-col">
                                            <flux:heading level="3" size="lg">
                                                Assigned Roles
                                            </flux:heading>
                                            <flux:text variant="subtle" class="text-[0.65rem]">
                                                At least one role need to be applied.
                                            </flux:text>
                                        </div>
                                        <div class="flex flex-wrap max-h-32 overflow-y-auto gap-1">
                                            @forelse($member->roles as $role)
                                                <flux:badge color="{{\App\Enums\RoleEnum::from($role->name)->color()}}"
                                                            size="sm"
                                                            class="h-fit w-fit">
                                                    {{ ucfirst($role->name) }}
                                                    @if($member->roles->count() > 1)
                                                        <flux:badge.close
                                                            wire:click="removeRole({{ $member->id }}, {{ $role->id }})"/>
                                                    @endif
                                                </flux:badge>
                                            @empty
                                                <flux:text>No role</flux:text>
                                            @endforelse
                                        </div>
                                    </div>
                                    <flux:separator/>
                                    <div class="flex flex-col gap-2.5">
                                        <div class="flex flex-col">
                                            <flux:heading level="3" size="lg">
                                                Roles
                                            </flux:heading>
                                            <flux:text variant="subtle" class="text-[0.65rem]">
                                                Click on a role to add it.
                                            </flux:text>
                                        </div>
                                        <div class="flex flex-wrap max-h-32 overflow-y-auto gap-1 h-fit">
                                            @foreach($roles->reject(
                                                fn($role) => $member->roles->contains('id', $role->id)
                                            ) as $role)
                                                <flux:badge color="{{\App\Enums\RoleEnum::from($role->name)->color()}}"
                                                            size="sm"
                                                            class="h-fit w-fit pointer-events-auto cursor-pointer"
                                                            wire:click="addRole({{ $member->id }}, {{ $role->id }})">
                                                    {{ ucfirst($role->name) }}
                                                </flux:badge>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                        </div>
                        @endif
                    </td>

                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600">
                        {{ $member->pivot->is_active ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600 text-nowrap">
                        {{ $member->pivot->created_at->locale('en_US')->diffForHumans() }}
                    </td>
                    <td class="px-4 py-3 text-right ">
                        <div class="flex justify-end gap-2">
                            @can(\App\Enums\PermissionEnum::ORG_MANAGE->value)
                                {{--<livewire:partials.edit-member :member="$member" :key="$member->id"/>--}}
                                <flux:button
                                    wire:click="editMember({{ $member->id }})"
                                    variant="primary" size="sm">
                                    Edit
                                </flux:button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        No members found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <flux:modal name="edit-member" class=" w-full max-w-96">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <flux:heading size="lg" level="3">Edit Member</flux:heading>
                <flux:text>Here you can edit a member.</flux:text>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <flux:label for="role">Member Roles</flux:label>
                    <div id="role" class="flex flex-wrap gap-2">
                        @foreach($memberToEdit->roles ?? [] as $memberRole)
                            <flux:badge color="{{\App\Enums\RoleEnum::from($memberRole->name)->color()}}"
                                        size="sm">
                                {{ ucfirst($memberRole->name) }}
                                <flux:badge.close/>
                            </flux:badge>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </flux:modal>

</div>
