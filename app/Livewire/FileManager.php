<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use App\Models\Directories;
use App\Models\Files;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class FileManager extends HorixtComponent
{
    use WithFileUploads;

    public ?Directories $currentDirectory = null;
    public $breadcrumbs = [];

    #[Validate('max:10240')] /*Max file size 10MB*/
    public $upload;

    /*Modal*/
    public bool $contextMenu = false;
    public $x = 0;
    public $y = 0;

    public $selectedFile;

    public function mount()
    {
        $this->currentDirectory = auth()->user()->directories()
            ->where('path', 'like', '%personal/' . auth()->user()->uuid . '%')
            ->where('user_id', auth()->id())
            ->whereNull('parent_id')
            ->first();
        $this->buildBreadcrumbs();
    }

    public function navigateToDirectory($id)
    {
        $dir = Directories::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->currentDirectory = $dir;
        $this->buildBreadcrumbs();
    }

    public function buildBreadcrumbs()
    {
        $breadcrumbs = [];

        $dir = $this->currentDirectory;
        while ($dir) {
            $breadcrumbs[] = $dir;
            $dir = $dir->parent;
        }

        $this->breadcrumbs = array_reverse($breadcrumbs);
    }


    public function createDirectory()
    {
        $name = 'New Folder';

        // Génère un nom unique si un dossier du même nom existe déjà
        $existing = $this->currentDirectory->children()
            ->where('name', 'LIKE', "{$name}%")
            ->count();

        if ($existing > 0) {
            $name .= " ({$existing})";
        }

        $path = $this->currentDirectory->path . '/' . Str::slug($name);

        // Crée le dossier physiquement
        Storage::disk('local')->makeDirectory("{$path}");

        // Enregistre en BDD
        $directory = Directories::create([
            'name' => $name,
            'path' => $path,
            'disk' => 'local',
            'visibility' => 'private',
            'locked' => false,
            'protected' => false,
            'user_id' => auth()->id(),
            'organization_id' => $this->currentDirectory->organization_id,
            'project_id' => $this->currentDirectory->project_id,
            'parent_id' => $this->currentDirectory->id,
        ]);


    }

    public function fileUploadModal()
    {
        Flux::modal('upload-file')->show();
    }

    public function uploadFile()
    {

        $file = $this->upload;

        $storagePath = $this->currentDirectory->path;
        $fileName = $file->getClientOriginalName();

        $storedPath = $file->storeAs(
            "{$storagePath}",
            $fileName
        );

        Files::create([
            'name' => pathinfo($fileName, PATHINFO_FILENAME),
            'alt' => null,
            'path' => $storagePath . '/' . $fileName,
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
            'disk' => 'local',
            'mime_type' => $file->getMimeType(),
            'visibility' => 'private',
            'checksum' => null, // tu peux ajouter plus tard
            'locked' => false,
            'user_id' => auth()->id(),
            'organization_id' => $this->currentDirectory->organization_id,
            'project_id' => $this->currentDirectory->project_id,
            'directory_id' => $this->currentDirectory->id,
        ]);

        $this->reset('upload');
        Flux::modal('upload-file')->close();
    }

    public function download()
    {
        return Storage::disk('local')->download($this->selectedFile->path);
    }

    public function toggleContextMenu(?int $x, ?int $y)
    {
        $this->x = $x ?? 0;
        $this->y = $y ?? 0;
        $this->contextMenu = !$this->contextMenu;
    }

    public function fileModal($id)
    {
        $this->selectedFile = Files::find($id);
        Flux::modal('file-modal')->show();
    }

    public function render()
    {

        $directories = $this->currentDirectory->children ?? [];
        $files = $this->currentDirectory->files ?? [];

        return view('livewire.file-manager', [
            'directories' => $directories,
            'files' => $files,
        ]);
    }
}
