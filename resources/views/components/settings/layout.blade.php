<div class="flex flex-col items-start w-full">
    <div class="flex flex-col mb-4 w-full">
     <flux:heading size="lg" >{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
    </div>

        <div class="w-full">
            {{ $slot }}
        </div>
</div>
