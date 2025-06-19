{{--
<div class="mr-auto hidden lg:block">

    <flux:breadcrumbs>
        @foreach ($breadcrumbs as $breadcrumb)
            <flux:breadcrumbs.item
                href="{{ $breadcrumb['url'] }}"
                icon="{{ $breadcrumb['icon'] ?? null }}"
                class="truncate! max-w-28! overflow-ellipsis! whitespace-nowrap!"
            >
                {{ $breadcrumb['label'] }}
            </flux:breadcrumbs.item>
        @endforeach
    </flux:breadcrumbs>
</div>
--}}

<div class="mr-auto hidden lg:block">
    <flux:breadcrumbs>
        @if (isset($breadcrumbs[0]))
            <flux:breadcrumbs.item
                href="{{ $breadcrumbs[0]['url'] }}"
                icon="{{ $breadcrumbs[0]['icon'] ?? null }}"
                class="truncate! max-w-28! overflow-ellipsis! whitespace-nowrap!"
            >
                {{ $breadcrumbs[0]['label'] }}
            </flux:breadcrumbs.item>
        @endif

        @if (count($breadcrumbs) > 3)
            <flux:breadcrumbs.item>
                <flux:dropdown>
                    <flux:button icon="ellipsis-horizontal" variant="ghost" size="sm" />

                    <flux:navmenu>
                        @foreach(array_slice($breadcrumbs, 1, -1) as $breadcrumb)
                            <flux:navmenu.item
                                href="{{ $breadcrumb['url'] }}"
                                icon="{{ $breadcrumb['icon'] ?? 'arrow-turn-down-right' }}"
                            >
                                {{ $breadcrumb['label'] }}
                            </flux:navmenu.item>
                        @endforeach
                    </flux:navmenu>
                </flux:dropdown>
            </flux:breadcrumbs.item>
            @else
            @foreach(array_slice($breadcrumbs, 1, -1) as $breadcrumb)
                <flux:breadcrumbs.item
                    href="{{ $breadcrumb['url'] }}"
                    icon="{{ $breadcrumb['icon'] ?? null }}"
                >
                    {{ $breadcrumb['label'] }}
                </flux:breadcrumbs.item>
            @endforeach
        @endif

        @if (count($breadcrumbs) > 1)
            @php $last = $breadcrumbs[count($breadcrumbs) - 1]; @endphp
            <flux:breadcrumbs.item
                href="{{ $last['url'] }}"
                icon="{{ $last['icon'] ?? null }}"
                class="truncate! max-w-28! overflow-ellipsis! whitespace-nowrap!"
            >
                {{ $last['label'] }}
            </flux:breadcrumbs.item>
        @endif
    </flux:breadcrumbs>
</div>
