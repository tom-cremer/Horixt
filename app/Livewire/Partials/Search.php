<?php

namespace App\Livewire\Partials;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Search extends HorixtComponent
{
    public $search = '';
    public $searchResults = [];


    public function searchGlobal()
    {
        if (str_starts_with($this->search, '@todo')) {
            $query = trim(str_replace('@todo', '', $this->search));
            return ['todos' => Todo::search($query)->get()];
        }

        if (str_starts_with($this->search, '@project')) {
            $query = trim(str_replace('@project', '', $this->search));
            return ['projects' => Project::search($query)->get()];
        }

        if (Context::isOrganization()) {
            $members = Context::getOrganization()->members->pluck('id')->toArray();

            if (str_starts_with($this->search, '@member')) {
                $query = trim(str_replace('@member', '', $this->search));
                return ['members' => User::search($query)->whereIn('id', $members)->get()];
            }

            return [
                'todos' => Todo::search($this->search)->get(),
                'projects' => Project::search($this->search)->get(),
                'members' => User::search($this->search)->whereIn('id', $members)->get(),
            ];

        }

        // Default: search everything
        return [
            'todos' => Todo::search($this->search)->get(),
            'projects' => Project::search($this->search)->get(),
        ];
    }

    protected function isDate($input)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $input);
    }

    public function render()
    {
        if (empty($this->search)) {
            $this->searchResults = [];
        } else {
            $this->searchResults = $this->searchGlobal();
        }
        return view('livewire.partials.search');
    }
}
