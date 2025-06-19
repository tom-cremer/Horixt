<?php

namespace App\Livewire\Partials\Notifications;

use App\Enums\NotificationType;
use App\Livewire\Component\HorixtComponent;
use App\Models\Notification;
use App\Models\Todo;
use App\Models\User;

class Assignment extends HorixtComponent
{
    public $notificationId;
    public $notification;

    public $todo;
    public $author;

    public $type = true;
    public $unread = false;

    public function mount($notificationId): void
    {
        $this->notificationId = $notificationId;
        $this->notification = Notification::find($notificationId);

        if ($this->notification->type === NotificationType::UNASSIGNMENT) {
            $this->type = false;
        }

        if ($this->notification) {
            $this->unread = $this->notification->read_at === null;
            $this->todo = Todo::find($this->notification->data['todo_id'] ?? null);
            $this->author = User::find($this->notification->data['author_id'] ?? null);
        }
    }

    public function markAsRead()
    {
        $this->notification->markAsRead();
        self::refresh();

    }

    public function markAsUnread()
    {
        $this->notification->markAsUnread();
        self::refresh();
    }

    public function viewTodo()
    {
        $project = $this->todo->project;

        // expand task parent of the todo if it exists
        if ($this->todo->parent) {
            $parent = $this->todo->parent;
            while ($parent) {
                session(["todo_{$parent->id}_expanded" => true]);
                $parent = $parent->parent;
            }
        }

        // mark the notification as read
        $this->notification->markAsRead();

        // redirect to the project of the todo
        if (!empty($project)) {
            if ($project->organization_id) {
                return redirect()->route('organization.projects.show', ['projectid' => $project->id, 'slug' => $project->organization->slug]);
            }
            return redirect()->route('personal.projects.show', ['projectid' => $project->id]);
        }

    }

    public function refresh()
    {
        $this->notification = Notification::find($this->notificationId);

        if ($this->notification->type === NotificationType::UNASSIGNMENT) {
            $this->type = false;
        }

        if ($this->notification) {
            $this->unread = $this->notification->read_at === null;
            $this->todo = Todo::find($this->notification->data['todo_id'] ?? null);
            $this->author = User::find($this->notification->data['author_id'] ?? null);
        }
    }


    #[On('mark-all-as-read')]
    public function render()
    {

        return view('livewire.partials.notifications.assignment');
    }
}
