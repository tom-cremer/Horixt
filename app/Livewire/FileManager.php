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

    public $newFileName;
    public $renameFileId;

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

    public function renameDirectory($id)
    {

    }

    public function fileUploadModal()
    {
        Flux::modal('upload-file')->show();
    }

    public function uploadFile()
    {
        $this->validate([
            'upload' => 'required|file|max:10240',
        ]);

        $file = $this->upload;

        $storagePath = $this->currentDirectory->path;
        $originalName = $file->getClientOriginalName();

        $baseName = pathinfo($originalName, PATHINFO_FILENAME); // sans extension
        $extension = $file->getClientOriginalExtension(); // extension seule

        // Préparer nom de fichier cible
        $fileName = $baseName . '.' . $extension;

        // Vérifier les doublons dans la DB (dans ce dossier uniquement)
        $existingNames = $this->currentDirectory->files()
            ->where('name', 'LIKE', "{$baseName}%")
            ->where('extension', $extension)
            ->pluck('name')
            ->toArray();

        if (in_array($baseName, $existingNames)) {
            $i = 1;
            while (in_array("{$baseName} ({$i})", $existingNames)) {
                $i++;
            }
            $baseName = "{$baseName} ({$i})";
            $fileName = $baseName . '.' . $extension;
        }

        // Stocker le fichier
        $storedPath = $file->storeAs($storagePath, $fileName);

        // Créer l’entrée en base
        Files::create([
            'name' => $baseName,
            'alt' => null,
            'path' => $storagePath . '/' . $fileName,
            'size' => $file->getSize(),
            'extension' => $extension,
            'disk' => 'local',
            'mime_type' => $file->getMimeType(),
            'visibility' => 'private',
            'checksum' => null,
            'locked' => false,
            'user_id' => auth()->id(),
            'organization_id' => $this->currentDirectory->organization_id,
            'project_id' => $this->currentDirectory->project_id,
            'directory_id' => $this->currentDirectory->id,
        ]);

        $this->reset('upload');
        Flux::modal('upload-file')->close();
        $this->dispatch('toast', [
            'title' => 'File Uploaded',
            'message' => 'The file has been uploaded successfully.',
            'type' => 'success',
         ]);
    }

    public function renameFile($id)
    {
        $file = Files::find($id);
        $this->renameFileId = $file->id;
        $this->newFileName = $file->name;
    }

    public function submitRenameFile()
    {
        $this->validate([
            'newFileName' => 'required|string|max:255',
        ]);

        $file = Files::find($this->renameFileId);

        $baseName = $this->newFileName;
        $extension = $file->extension; // extension seule

        // Préparer nom de fichier cible
        $fileName = $baseName;

        // Vérifier les doublons dans la DB (dans ce dossier uniquement)
        $existingNames = $this->currentDirectory->files()
            ->where('name', 'LIKE', "{$baseName}%")
            ->where('extension', $extension)
            ->where('id', '!=', $file->id)
            ->pluck('name')
            ->toArray();

        if (in_array($baseName, $existingNames)) {
            $i = 1;
            while (in_array("{$baseName} ({$i})", $existingNames)) {
                $i++;
            }
            $baseName = "{$baseName} ({$i})";
            $fileName = $baseName;
        }
        // Get the old and new paths
        $oldPath = $file->path;
        $newPath = str_replace($file->name, $fileName, $file->path);

        // Move the file in storage
        if (Storage::disk('local')->exists($oldPath)) {

            Storage::disk('local')->move($oldPath, $newPath);



            // Update database record
            $file->name = $fileName;
            $file->path = $newPath;
            $file->save();

            $this->reset('newFileName', 'renameFileId');
        }
    }
    public function deleteFile($id)
    {
        $file = Files::find($id);
        Storage::disk('local')->delete($file->path);
        $file->delete();
    }

    public function deleteSelectedFile()
    {
        Storage::disk('local')->delete($this->selectedFile->path);
        $this->selectedFile->delete();
        Flux::modal('file-modal')->close();
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
