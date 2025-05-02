<?php

namespace App\Traits;

use App\Helper\Context;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;

trait CreateTodo
{
    public function createTodo(array $data)
    {
       $validatedData = validator($data, [
           'name' => 'required|string|max:255',
           'description' => 'nullable|string',
           'status_id' => 'required|exists:statuses,id',
           'priority_id' => 'required|exists:priorities,id',
           'color_id' => 'required|exists:colors,id',
           'project_id' => 'nullable|exists:projects,id',
           'parent_id' => 'nullable|exists:todos,id',
       ])->validate();


        return Context::isOrganization() ?

            Todo::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'is_done' => false,
                'status_id' => $validatedData['status_id'] ?? Status::DEFAULT,
                'priority_id' => $validatedData['priority_id'] ?? Priority::DEFAULT,
                'color_id' => $validatedData['color_id'] ?? Color::DEFAULT,
                'user_id' => auth()->id(),
                'project_id' => $validatedData['project_id'] ?? null,
                'organization_id' => Context::getOrganizationId(),
                'parent_id' => $validatedData['parent_id'] ?? null,
            ])
            : Todo::create([

                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'is_done' => false,
                'status_id' => $validatedData['status_id'] ?? Status::DEFAULT,
                'priority_id' => $validatedData['priority_id'] ?? Priority::DEFAULT,
                'color_id' => $validatedData['color_id'] ?? Color::DEFAULT,
                'user_id' => auth()->id(),
                'project_id' => $validatedData['project_id'] ?? null,
                'organization_id' => null,
                'parent_id' => $validatedData['parent_id'] ?? null,
            ]);

    }
}
