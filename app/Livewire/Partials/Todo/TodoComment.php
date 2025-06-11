<?php

namespace App\Livewire\Partials\Todo;

use App\Helper\Context;
use App\Helper\NotificationHelper;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Todo;
use App\Models\TodoComment as TodoCommentModel;
use Flux\Flux;

class TodoComment extends HorixtComponent
{

    public Todo $todo;
    public $comments;

    public $content;
    public $is_private = false;

    /*Replies*/
    public $replyContent = [];

    /*Editing Comment*/
    public $editingContent;
    public $editingCommentId;

    /*Editing Reply*/
    public $editingReplyContent;
    public $editingReplyId;


    public function mount(Todo $todo)
    {
        $this->todo = $todo;
    }


    public function openModal()
    {

        Flux::modal('todo-comment-' . $this->todo->id)->show();

    }

    public function addComment()
    {
        TimezoneHelper::set();
        $this->validate([
            'content' => 'required|string|max:300',
        ]);

        TodoCommentModel::create([
            'todo_id' => $this->todo->id,
            'user_id' => auth()->id(),
            'comment' => $this->content,
            'is_private' => $this->is_private,
        ]);

        if (Context::isOrganization()) {
            foreach ($this->todo->assignees as $assignee) {
                if ($assignee->id !== auth()->user()->id) {
                    NotificationHelper::comment($this->todo->id, $assignee->id, auth()->user()->id);
                }
            }
        }


        $this->reset(['content']);
    }

    public function replyToComment($commentId)
    {
        TimezoneHelper::set();
        $this->validate([
            "replyContent.$commentId" => 'required|string|max:300',
        ]);

        TodoCommentModel::create([
            'todo_id' => $this->todo->id,
            'user_id' => auth()->id(),
            'comment' => $this->replyContent[$commentId],
            'parent_id' => $commentId,
            'is_private' => $this->is_private,
        ]);
        $this->reset(['replyContent']);
    }

    public function editComment($commentId)
    {
        TimezoneHelper::set();
        $comment = TodoCommentModel::findOrFail($commentId);
        $this->editingContent = $comment->comment;
        $this->editingCommentId = $commentId;
    }

    public function updateComment()
    {
        TimezoneHelper::set();
        $this->validate([
            'editingContent' => 'required|string|max:300',
        ]);

        $comment = TodoCommentModel::findOrFail($this->editingCommentId);
        $comment->update(['comment' => $this->editingContent]);
        $this->reset(['editingContent', 'editingCommentId']);
    }

    public function cancelEdit()
    {
        $this->reset(['editingContent', 'editingCommentId']);
    }

    public function deleteComment($commentId)
    {
        $comment = TodoCommentModel::findOrFail($commentId);
        $comment->delete();
    }

    public function editReply($replyId)
    {
        TimezoneHelper::set();
        $reply = TodoCommentModel::findOrFail($replyId);
        $this->editingReplyContent = $reply->comment;
        $this->editingReplyId = $replyId;
    }

    public function updateReply()
    {
        TimezoneHelper::set();
        $this->validate([
            'editingReplyContent' => 'required|string|max:300',
        ]);

        $reply = TodoCommentModel::findOrFail($this->editingReplyId);
        $reply->update(['comment' => $this->editingReplyContent]);
        $this->reset(['editingReplyContent', 'editingReplyId']);
    }

    public function cancelReplyEdit()
    {
        $this->reset(['editingReplyContent', 'editingReplyId']);
    }

    public function deleteReply($replyId)
    {
        $reply = TodoCommentModel::findOrFail($replyId);
        $reply->delete();
    }

    public function render()
    {
        $this->comments = $this->todo->comments()
            ->orderBy('updated_at', 'desc')->get();

        return view('livewire.partials.todo.todo-comment');
    }
}
