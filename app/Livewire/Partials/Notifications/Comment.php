<?php

namespace App\Livewire\Partials\Notifications;

use App\Models\Notification;
use App\Models\Todo;
use App\Models\User;
use Livewire\Component;

class Comment extends Component
{

    public $notificationId;
    public $notification;
    public $unread = false;

    public $todo;
    public $author;


    public function mount($notificationId): void
    {
        $this->notificationId = $notificationId;
        $this->notification = Notification::find($notificationId);

        if ($this->notification) {
            $this->unread = $this->notification->read_at === null;
            $this->todo = Todo::find($this->notification->data['todo_id'] ?? null);
            $this->author = User::find($this->notification->data['author_id'] ?? null);
        }
    }
    public function viewTodo()
    {
        $project = $this->todo->project;

        if (!empty($project)) {
            if ($project->organization_id) {
                return redirect()->route('organization.projects.show', ['projectid' => $project->id, 'slug' => $project->organization->slug]);
            }
            return redirect()->route('personal.projects.show', ['projectid' => $project->id]);
        }
    }

    public function markAsRead()
    {
        $this->notification->markAsRead();
        self::refresh();
        $this->dispatch('notificationRead');
    }

    public function refresh()
    {
        $this->notification = Notification::find($this->notificationId);
        $this->unread = $this->notification->read_at === null;
        $this->todo = Todo::find($this->notification->data['todo_id'] ?? null);
        $this->author = User::find($this->notification->data['author_id'] ?? null);
    }

    public function render()
    {
        return view('livewire.partials.notifications.comment');
    }
}
