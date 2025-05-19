<div class="h-full relative"
     wire:keydown.ctrl.f.window.prevent="createDirectory"
>
    <div
        x-data="{
            mouseX: 0,
            mouseY: 0
        }"
        @contextmenu.prevent="
            mouseX = $event.clientX;
            mouseY = $event.clientY;
            $wire.toggleContextMenu(mouseX, mouseY)
        "
        class="h-full relative"
    >

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
        <div class="flex flex-col gap-2 mt-4">
            @foreach ($directories as $directory)
                <div wire:key="directory-{{$directory->id}}"
                     class="p-1 bg-zinc-100 rounded shadow cursor-pointer hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600"
                     wire:click="navigateToDirectory({{ $directory->id }})">
                    📁 {{ $directory->name }}
                </div>
            @endforeach
        </div>

        {{-- Files --}}
        <div class="flex flex-col gap-2 mt-4">
            @foreach ($files as $file)
                <div wire:key="file-{{$file->id}}"
                     wire:click="fileModal({{$file->id}})"
                     class=" p-1 bg-zinc-100 rounded shadow cursor-pointer hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600">
                    📄 {{ $file->name .'.'. $file->extension }}
                </div>
            @endforeach
        </div>
    </div>
    @if($contextMenu)
        <div
            @contextmenu.prevent=""
            x-on:contextmenu.prevent
            wire:click.outside="toggleContextMenu(0, 0)"
            class="absolute z-10 p-2 bg-white dark:bg-zinc-700 rounded shadow border border-zinc-200 dark:border-zinc-600
             min-w-72 flex flex-col gap-2
            "
            style="top: {{ $y-65 }}px; left: {{ $x - (session('collapsed')? '80' : '310') }}px;"
        >
            <div class="flex flex-row justify-end items-center gap-2">
                <flux:button square :loading="false" variant="subtle" icon="x" size="xs"
                             wire:click="toggleContextMenu(0, 0)"
                />
            </div>
            <div class="flex flex-col gap-2">
                <flux:button
                    icon="upload"
                    variant="subtle"
                    size="sm"
                    :loading="false"
                    wire:click="fileUploadModal"
                    class="justify-start!"
                >
                    Upload File
                </flux:button>
                <flux:button
                    icon="folder-plus"
                    variant="subtle"
                    size="sm"
                    :loading="false"
                    wire:click="createDirectory"
                    class="justify-start!"
                >
                    New Folder
                </flux:button>

            </div>
        </div>
    @endif

    <flux:modal name="file-modal" variant="flyout">
        <div class="space-y-6">
            <flux:heading>File Details</flux:heading>
            <flux:separator/>
            @if($selectedFile)
                <div class="flex flex-col justify-center items-center gap-3.5">
                    <div class="flex flex-col gap-3 items-center justify-center">
                        <div class="h-48 w-48 rounded-lg">
                            <img
                                src="{{ Storage::disk('local')->temporaryUrl($selectedFile->path, now()->addMinutes(5)) }}"
                                class="w-full h-full object-contain rounded-lg" alt="{{$selectedFile->alt}}">
                        </div>
                        <flux:heading level="2" size="lg">{{$selectedFile->name .'.'. $selectedFile->extension}}</flux:heading>
                    </div>

                    <div class="flex flex-row justify-self-end w-full mt-auto">
                        <flux:spacer/>
                        <flux:button icon="download" variant="primary" wire:click="download">Download</flux:button>
                    </div>
                </div>

            @endif
        </div>
    </flux:modal>
    <flux:modal name="upload-file" class="w-96!">
        <div class="space-y-6">
            <flux:heading>Upload File</flux:heading>
            <flux:text variant="subtle">Maximum 10mb per file</flux:text>

            <flux:input type="file" wire:model="upload" label="File"/>
            <div class="flex flex-row justify-end">

                <flux:button type="submit" variant="primary" wire:click="uploadFile">Upload</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
