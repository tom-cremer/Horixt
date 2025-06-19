<div class="h-screen w-full grid grid-cols-[auto_1fr] font-lexend" wire:poll.5s>
    <aside class="w-64 bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700 p-4">

        <div class="flex items-center space-x-2 mb-6">
            <x-app-logo-icon/>
            <flux:heading level="1" size="xl" class="font-bold!">{{config('app.name')}}</flux:heading>
        </div>
        {{-- <flux:navlist>
             <flux:navlist.item href="{{ route('admin.dashboard') }}" icon="home" active>
                 Dashboard
             </flux:navlist.item>
             <flux:navlist.item href="{{ route('admin.users.index') }}" icon="users">
                 Users
             </flux:navlist.item>
             <flux:navlist.item href="{{ route('admin.settings') }}" icon="settings">
                 Settings
             </flux:navlist.item>
             <flux:navlist.item href="{{ route('admin.logs') }}" icon="file-text">
                 Logs
             </flux:navlist.item>
             <flux:navlist.item href="{{ route('admin.analytics') }}" icon="bar-chart">
                 Analytics
             </flux:navlist.item>
         </flux:navlist>--}}
    </aside>
    <div class="flex flex-col h-full ">
        <header
            class="flex items-center justify-between  gap-4 bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 p-4">
            <h1 class="text-xl font-semibold">Admin Dashboard</h1>
            <div>
                <flux:button x-data size="sm" x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                             aria-label="Toggle dark mode"/>
            </div>
        </header>
        <div class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{--User Count--}}
                <div
                    class="min-h-20 flex flex-col gap-1.5 shadow-md rounded-xl p-2.5"
                    style="background: linear-gradient(-135deg, #a39cff 0%, #8a83f2 100%);">
                    <flux:text variant="strong" class="text-lg font-semibold text-white">Total Users</flux:text>
                    <div class="flex flex-col gap-2 justify-between h-full">
                        <flux:text variant="strong" class="ml-1 text-4xl font-bold text-white">
                            {{ $usersCount }}
                        </flux:text>

                        @if ($this->getUserCreatedThisMonth() > 0)
                            <p class="text-green-400  text-xs font-normal mt-auto"><span
                                    class="border-[1.5px] min-w-2 max-w-fit  text-center border-green-400 px-[3px] text-xs font-medium rounded-md">+{{ $this->getUserCreatedThisMonth() }}</span>
                                Increased this month</p>
                        @elseif ($this->getUserCreatedThisMonth() < 0)
                            <p class="text-red-300 text-xs font-normal mt-auto"><span
                                    class="border-[1.5px] min-w-2 max-w-fit  text-center border-red-300 px-[3px] text-xs font-medium rounded-md">{{ $this->getUserCreatedThisMonth() }}</span>
                                Decreased this month</p>
                        @else
                            <p class="text-violet-950 font-normal text-xs mt-auto"><span
                                    class="border-[1.5px] min-w-2 max-w-fit  text-center border-violet-950 px-[3px] text-xs font-medium rounded-md">+{{ $this->getUserCreatedThisMonth() }}</span>
                                this month</p>
                        @endif
                    </div>
                </div>
                {{--Org Count--}}
                <div
                    class="min-h-20 flex flex-col gap-1.5 shadow-md rounded-xl p-2.5
                    bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600">
                    <flux:text variant="strong" class="text-lg font-semibold">Total Organizations</flux:text>
                    <div class="flex flex-col gap-2 justify-between h-full">
                        <flux:text variant="strong" class="ml-1 text-4xl font-bold ">
                            {{ $organizationsCount }}
                        </flux:text>

                        @if ($this->getOrganizationCreatedThisMonth() > 0)
                            <p class="text-green-400  text-xs font-normal mt-auto"><span
                                    class="border-[1.5px] min-w-2 max-w-fit  text-center border-green-400 px-[3px] text-xs font-medium rounded-md">+{{ $this->getOrganizationCreatedThisMonth() }}</span>
                                Increased this month</p>
                        @elseif ($this->getOrganizationCreatedThisMonth() < 0)
                            <p class="text-red-300 text-xs font-normal mt-auto"><span
                                    class="border-[1.5px] min-w-2 max-w-fit  text-center border-red-300 px-[3px] text-xs font-medium rounded-md">{{ $this->getOrganizationCreatedThisMonth() }}</span>
                                Decreased this month</p>
                        @else
                            <p class="text-violet-950 font-normal text-xs mt-auto"><span
                                    class="border-[1.5px] min-w-2 max-w-fit  text-center border-violet-950 px-[3px] text-xs font-medium rounded-md">+{{ $this->getOrganizationCreatedThisMonth() }}</span>
                                this month</p>
                        @endif
                    </div>
                </div>

                <div></div>


            </div>
            {{--Add Badges--}}
            <div class="flex flex-col gap-4 mt-6">
                <flux:heading level="2" class="font-semibold text-2xl!">
                    Badges
                </flux:heading>
                {{--Badge Form--}}
                <div class="flex flex-col gap-2 mb-4 max-w-md">
                    <flux:input type="text" size="sm" wire:model="code" placeholder="Code"/>

                    <flux:input type="file" wire:model="lightImage" label="Light"/>
                    <flux:input type="file" wire:model="darkImage" label="Dark"/>

                    <div class="flex items-center justify-end gap-2">
                        <flux:spacer/>
                        <flux:button type="submit" variant="filled" size="sm" wire:click="save">Add Badge</flux:button>
                    </div>
                </div>
                {{--Badges List--}}
                <div class="flex flex-col gap-4">
                    <flux:heading level="2" class="font-semibold text-2xl!">
                        Badges List
                    </flux:heading>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        @foreach($badges as $badge)
                            <div
                                class="flex flex-col gap-2 p-4 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-sm"
                                wire:key="badge-{{ $badge->id }}-{{$badge->updated_at}}">
                                <div class="grid grid-cols-2 gap-2 mb-2">
                                    <img
                                        src="{{ Storage::temporaryUrl('badges/' . $badge->light_badge_image, now()->addMinutes(5)) }}"
                                        alt="{{ $badge->code }} Light"
                                        class="max-w-14 aspect-auto object-cover">
                                    <img
                                        src="{{ Storage::temporaryUrl('badges/' . $badge->dark_badge_image, now()->addMinutes(5)) }}"
                                        alt="{{ $badge->code }} Dark"
                                        class="max-w-14 aspect-auto object-cover ml-2">
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Badge Code</p>
                                    <flux:text variant="strong"
                                               class="text-lg font-semibold">{{ $badge->code }}</flux:text>
                                    <flux:text variant="strong"
                                               class="text-lg font-semibold break-words">{{ $badge->token }}</flux:text>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Created
                                        at: {{ $badge->created_at->format('Y-m-d H:i') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Updated
                                        at: {{ $badge->updated_at->format('Y-m-d H:i') }}</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <flux:button variant="filled" size="sm"
                                                     wire:click="editBadge({{ $badge->id }})">
                                            Edit
                                        </flux:button>
                                        <flux:button variant="danger" size="sm"
                                                     wire:click="deleteBadge({{ $badge->id }})">
                                            Delete
                                        </flux:button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
