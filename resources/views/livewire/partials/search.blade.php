{{-- The best athlete wants his opponent at his best. --}}
<div
    class="relative max-w-[500px] w-full"
    x-data="{
        showSuggestions: false,
        raw: @entangle('search'),
        mode: @entangle('mode'),
        updateSuggestions() {
            const trimmed = this.raw.trim();
            this.showSuggestions = trimmed.startsWith('@') && !['@todos', '@project', '@member'].some(tag => trimmed.startsWith(tag));
        },
        setTag(tag) {
            this.raw = tag + ' ';
            this.showSuggestions = false;
        }
    }"
    x-init="$watch('raw', () => updateSuggestions())"
>

    {{-- Input with badge --}}
    <div class="relative">
        <flux:input
            size="sm"
            x-model="raw"
            wire:model.live="search"
            type="text"
            wire:keydown.shift.tab.prevent="updateMode"
            wire:keydown.escape.window.prevent="resetSearch"
            placeholder="{{ __('Search') }}"
            class="z-10 bg-transparent text-black dark:text-white caret-black dark:caret-white"
        />

        @if($mode !== 'global')
            <flux:badge :color="$modeColors[$mode] ?? 'gray'" size="sm"
                        class="absolute z-20 top-1/2 right-3 transform -translate-y-1/2">
                {{ '@' . $mode }}
                <flux:badge.close wire:click="removeMode" class="cursor-pointer"/>
            </flux:badge>
        @endif
    </div>

    {{-- Suggestions dropdown --}}
    <div
        x-cloak
        x-show="showSuggestions"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        @click.away="showSuggestions = false"
        class="absolute top-12 left-0 w-full z-50 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600
               rounded-md shadow-md p-2 space-y-1"
    >
        <div @click="setTag('@todos')" class="px-3 py-1 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700">
            @todos
        </div>
        <div @click="setTag('@project')" class="px-3 py-1 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700">
            @project
        </div>
        {{--<div @click="setTag('@member')" class="px-3 py-1 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700">
            @member
        </div>--}}
    </div>

    {{-- No results message --}}
    @if($mode !== 'global' && empty($searchResults))
        <div class="absolute top-12 left-0 w-full z-40 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600
                    rounded-md shadow-lg p-2 text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('No results found.') }}
        </div>
    @endif

    {{-- Search results --}}
    @if(!empty($searchResults) && !empty($search))
        <div class="absolute top-12 left-0 w-full z-40 max-h-[300px] overflow-y-auto
                    bg-white border border-zinc-300 dark:bg-zinc-800 dark:border-zinc-600
                    rounded-md shadow-lg p-2 space-y-4">
            @foreach($searchResults as $key => $items)
                <div>
                    <flux:heading level="2" size="sm" class="mb-2">
                        {{ ucfirst($key) }}
                    </flux:heading>

                    @forelse($items as $item)
                        @if($key === 'todos')
                            <button wire:click="viewTodo({{$item['id']}})" class="block w-full text-left p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                <flux:text variant="strong">{{ $item['name'] }}</flux:text>
                                <flux:text variant="subtle" class="text-xs">
                                    {{ $item['description'] ?? $item['email'] ?? '' }}
                                </flux:text>
                            </button>
                        @endif
                        @if($key === 'projects')
                            <button wire:click="viewProject({{$item['id']}})" class="block w-full text-left p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                <flux:text variant="strong">{{ $item['name'] }}</flux:text>
                                <flux:text variant="subtle" class="text-xs">
                                    {{ $item['description'] ?? $item['email'] ?? '' }}
                                </flux:text>
                            </button>
                        @endif
                    @empty
                        <div class="text-zinc-500 dark:text-zinc-400 text-sm">No {{ $key }} found.</div>
                    @endforelse
                </div>
            @endforeach
        </div>
    @endif

</div>
