<div class="overflow-hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Members</h2>
        <input
            wire:model.debounce.300ms="search"
            type="text"
            placeholder="Search members..."
            class="border border-gray-300 rounded px-3 py-1"
        >
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-zinc-600 rounded-lg shadow overflow-auto">
            <thead class="bg-gray-100 dark:bg-zinc-600 text-left text-sm font-medium text-gray-700">
            <tr class="">
                <th class="px-4 py-3 text-black dark:text-white rounded-lg ">Name</th>
                <th class="px-4 py-3 text-black dark:text-white">Email</th>
                <th class="px-4 py-3 text-black dark:text-white">Role</th>
                <th class="px-4 py-3 text-black dark:text-white">Status</th>
                <th class="px-4 py-3 text-black dark:text-white">Joined</th>
                <th class="px-4 py-3 text-black dark:text-white text-right rounded-lg">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
            @forelse ($members as $member)
                <tr>
                    <td class="px-4 py-3 flex items-center gap-2">
                        <img src="" alt="{{ $member->name }}" class="w-8 h-8 rounded-full">
                        <span>{{ $member->name }}</span>
                    </td>
                    <td class="px-4 py-3">{{ $member->email }}</td>
                    <td class="px-4 py-3">
                        <flux:badge color="amber" size="sm">{{ $member->roles->first()?->name ?? '' }}</flux:badge>
                    </td>

                    <td class="px-4 py-3">
                        {{ $member->pivot->is_active ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $member->pivot->created_at->locale('en_US')->diffForHumans() }}
                    </td>
                    <td class="px-4 py-3 text-right">
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
