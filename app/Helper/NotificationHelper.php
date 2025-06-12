<?php

namespace App\Helper;

use App\Enums\NotificationType;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationHelper
{
    public static function assigned($todoId, $userId, $authorId, $is_assigned = true)
    {
        TimezoneHelper::set();
        // Validate the todoId and userId
        Notification::create([
            'user_id' => $userId,
            'type' => $is_assigned ? NotificationType::ASSIGNMENT : NotificationType::UNASSIGNMENT,
            'data' => [
                'todo_id' => $todoId,
                'author_id' => $authorId,
            ],
        ]);
    }


    public static function comment($todoId, $userId, $authorId)
    {
        TimezoneHelper::set();
        Notification::create([
            'user_id' => $userId,
            'type' => NotificationType::COMMENT,
            'data' => [
                'todo_id' => $todoId,
                'author_id' => $authorId,
            ],
        ]);
    }

    public static function reminder($todoId, $userId)
    {
        TimezoneHelper::set();
        Notification::create([
            'user_id' => $userId,
            'type' => NotificationType::REMINDER,
            'data' => [
                'todo_id' => $todoId,
            ],
        ]);
    }

    public static function message($userId, $authorId, ?int $conversationId = null)
    {
        TimezoneHelper::set();
        // If conversationId is provided, use it; otherwise, use todoId
        $data = $conversationId ? ['conversation_id' => $conversationId] : [];

        Notification::create([
            'user_id' => $userId,
            'type' => NotificationType::MESSAGE,
            'data' => array_merge($data, ['author_id' => $authorId]),
        ]);
    }

    public static function system($userId, $message)
    {
        TimezoneHelper::set();
        Notification::create([
            'user_id' => $userId,
            'type' => NotificationType::SYSTEM,
            'data' => [
                'message' => $message,
            ],
        ]);
    }

    public static function alert($userId, $message)
    {
        TimezoneHelper::set();
        Notification::create([
            'user_id' => $userId,
            'type' => NotificationType::ALERT,
            'data' => [
                'message' => $message,
            ],
        ]);
    }

    public static function invitation($userEmail, $token, $invitedById, $organizationId)
    {
        TimezoneHelper::set();
        $getUser = User::where('email', $userEmail)->first();

        Notification::create([
            'user_id' => $getUser->id ?? null,
            'type' => NotificationType::INVITATION,
            'data' => [
                'token' => $token,
                'email' => $userEmail,
                'invitedBy_id' => $invitedById,
                'organization_id' => $organizationId,
            ]
        ]);
    }

}
