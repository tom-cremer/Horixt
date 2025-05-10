<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div
        class="flex flex-wrap gap-2  relative overflow-hidden">
        @if (\App\Helper\Context::isOrganization())
            <h2 class="text-lg font-semibold">Organization</h2>
        @else
            <h2 class="text-lg font-semibold">Personal</h2>
        @endif
{{--
       <x-placeholder-pattern class="relative size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
--}}
    </div>
</div>
