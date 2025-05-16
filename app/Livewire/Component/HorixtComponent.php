<?php

namespace App\Livewire\Component;

use App\Helper\Context;
use Livewire\Component;

class HorixtComponent extends Component
{
    public function hydrate()
    {
        if (!session('team_id') || Context::isPersonal()) {
            return;
        }

        setPermissionsTeamId(session('team_id'));
    }
}
