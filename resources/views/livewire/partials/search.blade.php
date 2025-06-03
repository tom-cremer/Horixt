{{-- The best athlete wants his opponent at his best. --}}
{{--<div class="relative max-w-[500px] w-full">
    <flux:input
        size="sm"
        wire:model.live="search"
        wire:change="searchGlobal"
        type="text"
        placeholder="{{ __('Search') }}"
    />

    @if(!empty($searchResults))
        <div class="absolute top-10 right-0 z-50 max-w-[500px] w-full h-[200px] overflow-auto
        bg-white border border-zinc-300 dark:bg-zinc-700 dark:border-zinc-600 rounded-md shadow-lg
        p-2 flex flex-col gap-2">
            @foreach($searchResults as $key => $result)
                {{$key}}
                {{$result}}
            @endforeach
        </div>
    @endif
</div>--}}
<div x-data="{ query: $wire:entangle('search') }" class="relative max-w-[500px] w-full">

    {{-- Mirror with styled badges --}}
    {{--<div class="absolute inset-0 z-50 pointer-events-none px-3 py-[7px] text-sm font-normal
                whitespace-pre-wrap leading-[1.5rem] text-transparent"
         style="font-family: inherit;">

        <template x-for="word in query.split(' ')" :key="word">
            <template x-if="word.startsWith('@')">
                <span class="inline-block bg-blue-500 text-white px-2 py-0.5 rounded-md mr-1">
                    <span x-text="word"></span>
                </span>
            </template>
            <template x-if="!word.startsWith('@')">
                <span class="text-zinc-500 mr-1" x-text="word + ' '"></span>
            </template>
        </template>
    </div>--}}

    {{-- Real input field --}}
    <flux:input
        size="sm"
        wire:model.live="search"
        wire:change="searchGlobal"
        x-model="query"
        type="text"
        clearable
        class="relative z-10 bg-transparent text-black dark:text-white caret-black dark:caret-white"
        placeholder="{{ __('Search') }}"
    />


    {{-- Search Results --}}
    @if(!empty($searchResults))
        <div class="absolute top-10 right-0 z-40 max-w-[500px] w-full h-[200px] overflow-auto
                    bg-white border border-zinc-300 dark:bg-zinc-700 dark:border-zinc-600
                    rounded-md shadow-lg p-2 flex flex-col gap-2">
            @foreach($searchResults as $key => $result)
                @if(!empty($result))
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">
                        {{ ucfirst($key) }}
                    </h3>
                    @foreach($result as $item)

                        <div class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-md">
                            <a href="#" class="text-blue-600 dark:text-blue-400">
                                {{ $item['name'] }}
                            </a>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $item['description'] ?? $item['email'] }}</p>
                        </div>
                    @endforeach
                    <span class="block w-full border-t border-t-white"></span>
                @else
                    <div class="p-2 text-zinc-500 dark:text-zinc-400">
                        {{ __('No results found') }}
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
