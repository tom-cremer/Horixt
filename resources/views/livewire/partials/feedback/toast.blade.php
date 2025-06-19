<div
    x-data="{ timer: null }"
    x-init="$watch('$wire.visible', value => {
        if (value) {
            if (timer) clearTimeout(timer);
            timer = setTimeout(() => {
                $wire.hide();
            }, {{ $duration }});
        }
    })"

    @class([
     'font-lexend bg-zinc-50 dark:bg-zinc-600 border border-neutral-200 dark:border-neutral-500 fixed bottom-6 right-5 z-50 px-4 py-3 rounded-xl shadow text-sm max-w-sm transition-transform transition-opacity duration-400 ease-in-out',
     'opacity-0 translate-y-4' => !$visible,
     'opacity-100 translate-y-0' => $visible,
 ])
>
    <div class="grid grid-cols-[auto_1fr] gap-2">
        <div class="flex items-start justify-start gap-2">
            @if ($type === 'success')
                <flux:icon name="check-circle" class="w-5 h-5 text-green-500 dark:text-green-400"/>
            @elseif ($type === 'info')
                <flux:icon name="information-circle" class="w-5 h-5 text-blue-500 dark:text-blue-400"/>
            @elseif ($type === 'warning')
                <flux:icon name="exclamation-circle" class="w-5 h-5 text-yellow-500 dark:text-yellow-400"/>
            @elseif ($type === 'error')
                <flux:icon name="x-circle" class="w-5 h-5 text-red-500 dark:text-red-400"/>
            @else
                <flux:icon name="information-circle" class="w-5 h-5 text-zinc-500 dark:text-zinc-300"/>
            @endif
        </div>
        <div class="flex flex-col items-start justify-start gap-1">

            <flux:text variant="strong" class="font-bold!">
                {{ $title }}
            </flux:text>
            <flux:text variant="subtle">
                {{$message}}
            </flux:text>
        </div>
    </div>
</div>


