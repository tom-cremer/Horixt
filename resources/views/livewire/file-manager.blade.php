<div>
    <div >

        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            @foreach ($breadcrumbs as $crumb)
                <flux:breadcrumbs.item separator="slash">
                    <button wire:click="navigateToDirectory({{ $crumb->id }})" class="text-blue-500 hover:underline">
                        {{ $crumb->name }}
                    </button>
                </flux:breadcrumbs.item>
            @endforeach
        </flux:breadcrumbs>

        {{-- Subdirectories --}}
        <div class="grid grid-cols-4 gap-4 mt-4">
            @foreach ($directories as $directory)
                <div class="p-4 bg-gray-100 rounded shadow cursor-pointer hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600"
                     wire:click="navigateToDirectory({{ $directory->id }})">
                    📁 {{ $directory->name }}
                </div>
            @endforeach
        </div>

        {{-- Files --}}
        <div class="grid grid-cols-4 gap-4 mt-6">
            @foreach ($files as $file)
                <div class="p-4 bg-white rounded shadow">
                    📄 {{ $file->name }}
                </div>
            @endforeach
        </div>
    </div>
</div>
