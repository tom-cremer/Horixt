<?php

namespace App\Livewire;

use App\Models\Directories;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FileManager extends Component
{
    public ?Directories $currentDirectory = null;
    public $breadcrumbs = [];

    public function mount()
    {
        $this->currentDirectory = auth()->user()->directories()
            ->where('path', 'like', '%personal/' . auth()->user()->uuid . '%')
            ->where('user_id', auth()->id())
            ->where('parent_id', null)
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

    }

    public function render()
    {
        Log::info($this->currentDirectory);
        Log::info(auth()->user()->uuid);

        $directories = $this->currentDirectory->children ?? [];
        $files = $this->currentDirectory->files ?? [];

        return view('livewire.file-manager', [
            'directories' => $directories,
            'files' => $files,
        ]);
    }
}
