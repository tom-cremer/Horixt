<div class="mr-auto hidden lg:block">
    <flux:breadcrumbs>
        @foreach ($breadcrumbs as $breadcrumb)
            <flux:breadcrumbs.item
                href="{{ $breadcrumb['url'] }}"
                icon="{{ $breadcrumb['icon'] ?? null }}"
            >
                {{ $breadcrumb['label'] }}
            </flux:breadcrumbs.item>
        @endforeach
    </flux:breadcrumbs>
</div>
