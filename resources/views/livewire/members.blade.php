<div class="overflow-hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Members</h2>
        <livewire:partials.add-members/>
    </div>


    <div class="overflow-x-auto">
        <table class="min-w-full shadow overflow-auto border border-zinc-300 dark:border-zinc-600 ">
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
            @forelse ($members as $member)
                <tr class="border-b border-zinc-300 dark:border-zinc-600">
                    <td class=" px-4 py-3  border-r border-zinc-300 dark:border-zinc-600">
                        <div class="flex flex-nowrap items-center gap-2">

                            @if ($member->profile_photo_path)
                                <img src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}"
                                     class="w-8 h-8 rounded-full">
                            @else
                                <div class="min-w-8 min-h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500 text-sm">{{ $member->initials()}}</span>
                                </div>
                            @endif

                            <span>{{ $member->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600">
                        {{ $member->email }}
                    </td>
                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600">
                        <div class="flex items-center gap-2">
                            @if ($member->isOwner(\App\Helper\Context::getOrganizationId()))
                                <flux:badge color="green" size="sm">Owner</flux:badge>
                            @endif
                            @forelse($member->roles as $role)
                                <flux:badge color="{{\App\Enums\RoleEnum::from($role->name)->color()}}"
                                            size="sm">{{ ucfirst($role->name) }}</flux:badge>
                            @empty
                            @endforelse
                        </div>
                    </td>

                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600">
                        {{ $member->pivot->is_active ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-4 py-3 border-r border-zinc-300 dark:border-zinc-600 text-nowrap">
                        {{ $member->pivot->created_at->locale('en_US')->diffForHumans() }}
                    </td>
                    <td class="px-4 py-3 text-right ">
                        <div class="flex justify-end gap-2">
                            <button wire:click="edit({{ $member->id }})"
                                    class="text-blue-600 hover:underline text-sm">Edit
                            </button>
                            @if ($member->pivot->is_active)
                                <button wire:click="deactivate({{ $member->id }})"
                                        class="text-red-600 hover:underline text-sm">Deactivate
                                </button>
                            @else
                                <button wire:click="reactivate({{ $member->id }})"
                                        class="text-green-600 hover:underline text-sm">Reactivate
                                </button>
                            @endif
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
</div>
