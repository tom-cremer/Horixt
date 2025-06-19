<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Color;
use App\Models\Notes;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class NoteBoard extends HorixtComponent
{
    public $notes;
    public $title = '';
    public $content = '';
    public $color_id = null;

    public $noteToEditId;

    public $colors;

    public $mode = false; // false for Notes, true for Brief
    public $projectId = null;
    public $project = null;

    public function mount($projectId = null)
    {
        $this->projectId = $projectId;

        if ($projectId) {
            $this->mode = true;
        } else {
            $this->mode = false;
        }

        if ($this->projectId) {
            $this->project = Project::findOrFail($this->projectId);
        }
        Log::info('NoteBoard mounted with projectId: ' . $this->projectId);
        $this->colors = Color::all();
        $this->loadNotes();
    }

public function loadNotes()
{
    $this->notes = Notes::query()
        ->when(!$this->mode, function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->when($this->mode, function ($query) {
            $query->where('project_id', $this->projectId);
        })
        ->when(Context::isOrganization(), function ($query) {
            $query->where('organization_id', Context::getOrganizationId());
        })
        ->orderBy('created_at', 'desc')
        ->get();
}

    public function addNoteColor($colorId)
    {
        TimezoneHelper::set();
        Log::info('Creating note with projectId: ' . $this->projectId);

        $noteToEdit = Notes::create([
            'user_id' => auth()->id(),
            'organization_id' => Context::getOrganizationId() ?? null,
            'color_id' => $colorId,
            'project_id' => $this->mode ? $this->projectId : null,
            'title' => $this->mode ? 'New Brief' : 'New Note',
            'content' => '',
        ]);
        $this->noteToEditId = $noteToEdit->id;
        $this->title = $noteToEdit->title;
        $this->content = $noteToEdit->content;
        $this->color_id = $noteToEdit->color_id;
        $this->loadNotes();

        if ($this->mode) {
            $this->dispatch('toast', [
                'title' => 'Brief Created',
                'message' => 'Brief has been successfully created.',
                'type' => 'success', // success, warning, error, info
                //'duration' => Default 5000ms,
            ]);
        } else {
            $this->dispatch('toast', [
                'title' => 'Note created',
                'message' => 'Note has been successfully created.',
                'type' => 'success', // success, warning, error, info
                //'duration' => Default 5000ms,
            ]);
        }


    }

    public function editNote($noteId)
    {
        $this->noteToEditId = $noteId;
        $note = Notes::find($noteId);
        if ($note) {
            $this->title = $note->title;
            $this->content = $note->content;
            $this->color_id = $note->color_id;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'content', 'color_id', 'noteToEditId']);
    }

    public function updateNote()
    {
        TimezoneHelper::set();
        $note = Notes::find($this->noteToEditId);
        if ($note) {
            $this->validate([
                'title' => 'required|string|max:20',
                'content' => 'nullable|string|max:150',
                'color_id' => 'nullable|exists:colors,id',
            ]);
            $note->update([
                'title' => $this->title,
                'content' => $this->content,
                'color_id' => $this->color_id,
            ]);
            if ($this->mode) {
                $this->dispatch('toast', [
                    'title' => 'Brief Updated',
                    'message' => 'Brief has been successfully updated.',
                    'type' => 'success', // success, warning, error, info
                    //'duration' => Default 5000ms,
                ]);
            } else {
                $this->dispatch('toast', [
                    'title' => 'Note Updated',
                    'message' => 'Note has been successfully updated.',
                    'type' => 'success', // success, warning, error, info
                    //'duration' => Default 5000ms,
                ]);
            }
        }

        $this->reset(['title', 'content', 'color_id', 'noteToEditId']);
        $this->loadNotes();
    }

    public function deleteNote($noteId)
    {
        $note = Notes::find($noteId);
        if ($note) {
            $note->delete();
            $this->loadNotes();
            if ($this->mode) {
                $this->dispatch('toast', [
                    'title' => 'Brief Deleted',
                    'message' => 'Brief has been successfully deleted.',
                    'type' => 'success', // success, warning, error, info
                    //'duration' => Default 5000ms,
                ]);
            } else {
                $this->dispatch('toast', [
                    'title' => 'Note Deleted',
                    'message' => 'Note has been successfully deleted.',
                    'type' => 'success', // success, warning, error, info
                    //'duration' => Default 5000ms,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.note-board');
    }
}
