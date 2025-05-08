<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('personal.dashboard') }}">Dashboard</flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>

    <div
        class="flex flex-wrap gap-2  relative overflow-hidden rounded-xl">
        @if (\App\Helper\Context::isOrganization())
            <h2 class="text-lg font-semibold">Organization</h2>
            @role(\App\Enums\RoleEnum::ADMIN->value)
            I'm admin
            @else
            I'm not admin
            @endrole
        @else

            <h2 class="text-lg font-semibold">Personnal</h2>
        @endif
        {{--<x-placeholder-pattern class="relative size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />--}}
    </div>
</div>
