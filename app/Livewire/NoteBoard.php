<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Color;
use App\Models\Notes;

class NoteBoard extends HorixtComponent
{
    public $notes;
    public $title = '';
    public $content = '';
    public $color_id = null;

    public $noteToEditId;

    public $colors;

    public function mount()
    {
        $this->colors = Color::all();
        $this->loadNotes();
    }

    public function loadNotes()
    {
        $this->notes = Notes::where('user_id', auth()->id())
            ->when(Context::isOrganization(), function ($query) {
                $query->where('organization_id', Context::getOrganizationId());
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function addNoteColor($colorId)
    {
        TimezoneHelper::set();
        $noteToEdit = Notes::create([
            'user_id' => auth()->id(),
            'organization_id' => Context::getOrganizationId(),
            'color_id' => $colorId,
            'title' => 'New Note',
            'content' => '',
        ]);
        $this->noteToEditId = $noteToEdit->id;
        $this->title = $noteToEdit->title;
        $this->content = $noteToEdit->content;
        $this->color_id = $noteToEdit->color_id;
        $this->loadNotes();
        $this->dispatch('toast', [
            'title' => 'Note created',
            'message' => 'Note has been successfully created.',
            'type' => 'success', // success, warning, error, info
            //'duration' => Default 5000ms,
        ]);


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
                'title' => 'required|string|max:30',
                'content' => 'nullable|string|max:250',
                'color_id' => 'nullable|exists:colors,id',
            ]);
            $note->update([
                'title' => $this->title,
                'content' => $this->content,
                'color_id' => $this->color_id,
            ]);
            $this->dispatch('toast', [
                'title' => 'Note Updated',
                'message' => 'Note has been successfully updated.',
                'type' => 'success', // success, warning, error, info
                //'duration' => Default 5000ms,
            ]);
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
            $this->dispatch('toast', [
                'title' => 'Note Deleted',
                'message' => 'Note has been successfully deleted.',
                'type' => 'success', // success, warning, error, info
                //'duration' => Default 5000ms,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.note-board');
    }
}
