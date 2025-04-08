    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            </flux:breadcrumbs>

        </div>

        <div class="flex flex-wrap gap-2 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @foreach($colors as $color)
                <div class="inline-block  p-2 w-56 text-center rounded-xl {{$color->alias}} {{$color->alias}}--text flex items-center justify-center ">
                    {{ $color->name }}
                </div>
            @endforeach
            {{--<x-placeholder-pattern class="relative size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />--}}
        </div>
    </div>
