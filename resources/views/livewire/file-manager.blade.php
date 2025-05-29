<div class="h-full relative  gap-4"
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
                <div
                    wire:key="directory-{{$directory->id}}"
                    class=" p-1 bg-zinc-100 rounded shadow cursor-pointer hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600
                     flex flex-row justify-between items-center gap-2">
                    @if($renameDirectoryId === $directory->id)

                        <flux:input clearable type="text" size="xs" wire:model.live="renameDirectoryName"
                                    placeholder="Rename File"/>
                        <flux:button icon="check" variant="subtle" size="xs" wire:click="submitRenameDirectory"/>
                        <flux:button icon="x" variant="subtle" size="xs" wire:click="cancelRenameDirectory"/>
                    @else
                        <div class="flex flex-row gap-2 items-center w-full"
                             wire:click="navigateToDirectory({{ $directory->id }})"
                        >
                            📁 {{ $directory->name }}
                        </div>
                        @if((!$directory->protected && !$directory->locked) &&
                            (\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::FILES_RENAME)))
                            <flux:button icon="square-pen" variant="subtle" size="xs"
                                         wire:click="renameDirectory({{ $directory->id }})"/>
                        @endif
                    @endif
                    @if((!$directory->protected && !$directory->locked) &&
                        (\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::FILES_DELETE)))
                        <flux:button icon="trash-2" variant="subtle" size="xs"
                                     wire:click="deleteDirectory({{ $directory->id }})"/>
                    @endif


                </div>
            @endforeach
        </div>

        {{-- Files --}}
        <div class="flex flex-col gap-2 mt-4">
            @foreach ($files as $file)
                <div wire:key="file-{{$file->id}}"

                     class=" p-1 bg-zinc-100 rounded shadow cursor-pointer hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600
                     flex flex-row justify-between items-center gap-2">
                    @if($renameFileId === $file->id)

                        <flux:input clearable type="text" size="xs" wire:model.live="newFileName"
                                    placeholder="Rename File"/>
                        <flux:button icon="check" variant="subtle" size="xs" wire:click="submitRenameFile"/>
                        <flux:button icon="x" variant="subtle" size="xs" wire:click="cancelRenameFile"/>
                    @else
                        <div class="flex flex-row gap-2 items-center w-full"
                             wire:click="fileModal({{$file->id}})">

                            📄 {{ $file->name .'.'. $file->extension }}

                        </div>
                    @endif
                    @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::FILES_LOCK))
                        @if($file->locked)
                            <flux:button icon="lock-open" variant="subtle" size="xs"
                                         wire:click="toggleFileLock({{ $file->id }})"/>
                        @else
                            <flux:button icon="lock" variant="subtle" size="xs"
                                         wire:click="toggleFileLock({{ $file->id }})"/>
                        @endif
                    @endif

                    @if(($renameFileId === $file->id || \App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::FILES_RENAME)) && !$file->locked)
                        <flux:button icon="square-pen" variant="subtle" size="xs"
                                     wire:click="renameFile({{ $file->id }})"/>
                    @endif
                    @if((\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::FILES_DELETE) ) &&
                            !$file->locked)
                        <flux:button icon="trash-2" variant="subtle" size="xs"
                                     wire:click="deleteFile({{ $file->id }})"/>
                    @endif
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

    <flux:modal name="file-modal" variant="flyout" class="max-w-96">
        <div class="space-y-6">
            <flux:heading>File Details</flux:heading>
            <flux:separator/>
            @if($selectedFile)
                <div class="flex flex-col justify-center items-center gap-3.5 overflow-y-auto ">
                    <div class="flex flex-col gap-3 items-center justify-center">
                        @if(str_contains($selectedFile->mime_type, 'image/'))
                            <div class="h-48 w-48 rounded-lg">
                                <img
                                    src="{{ Storage::disk('local')->temporaryUrl($selectedFile->path, now()->addMinutes(5)) }}"
                                    class="w-full h-full object-contain rounded-lg" alt="{{$selectedFile->alt}}">
                            </div>
                        @elseif(str_contains($selectedFile->mime_type, 'video/'))
                            <div>
                                <video class="w-full h-full object-contain rounded-lg" controls>
                                    <source
                                        src="{{ Storage::disk('local')->temporaryUrl($selectedFile->path, now()->addMinutes(5)) }}"
                                        type="video/mp4">
                                </video>
                            </div>
                        @else
                            <div
                                class="flex items-center justify-center h-48 w-48 rounded-lg bg-zinc-200 dark:bg-zinc-700">
                                <flux:icon.file class="size-12"/>
                            </div>
                        @endif
                        <flux:heading level="2"
                                      size="lg">{{$selectedFile->name .'.'. $selectedFile->extension}}</flux:heading>
                    </div>

                    <div class="flex flex-row justify-self-end w-full mt-auto gap-1.5">
                        <flux:spacer/>
                        <flux:button icon="download" variant="primary" wire:click="download">Download</flux:button>
                        <flux:button icon="trash-2" variant="danger" wire:click="deleteSelectedFile">Delete
                        </flux:button>
                    </div>
                </div>

            @endif
        </div>
    </flux:modal>
    <flux:modal name="upload-file"
                wire:keydown.shift.n.window.prevent="fileUploadModal"
                class="w-96!">
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
