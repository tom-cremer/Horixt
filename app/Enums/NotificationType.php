<?php

namespace App\Enums;

enum NotificationType: string
{
    case INVITATION = 'invitation';
    case REMINDER = 'reminder';
    case COMMENT = 'comment';
    case ASSIGNMENT = 'assignment';
    case UNASSIGNMENT = 'unassignment';
    case MESSAGE = 'message';
    case SYSTEM = 'system';
    case ALERT = 'alert';

    public function label(): string
    {
        return match ($this) {
            self::INVITATION => 'Invitation',
            self::REMINDER => 'Reminder',
            self::COMMENT => 'Comment',
            self::ASSIGNMENT => 'Assignment',
            self::UNASSIGNMENT => 'Unassignment',
            self::MESSAGE => 'Message',
            self::SYSTEM => 'System',
            self::ALERT => 'Alert',
        };
    }


}
