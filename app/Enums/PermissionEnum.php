<?php

namespace App\Enums;

enum PermissionEnum: string
{
    // Todos
    case TODOS_VIEW = 'todos.view';
    case TODOS_CREATE = 'todos.create';
    case TODOS_UPDATE = 'todos.update';
    case TODOS_DELETE = 'todos.delete';
    case TODOS_ASSIGN = 'todos.assign';
    case TODOS_REVIEW = 'todos.review';
    case TODOS_COMMENT = 'todos.comment';

    // Tracks
    case TRACKS_VIEW = 'tracks.view';
    case TRACKS_CREATE = 'tracks.create';
    case TRACKS_UPDATE = 'tracks.update';
    case TRACKS_DELETE = 'tracks.delete';


    // Files
    case FILES_VIEW = 'files.view';
    case FILES_UPLOAD = 'files.upload';
    case FILES_RENAME = 'files.rename';
    case FILES_DELETE = 'files.delete';
    case FILES_SHARE = 'files.share';
    case FILES_DOWNLOAD = 'files.download';
    case FILES_MOVE = 'files.move';
    case FILES_LOCK = 'files.lock';
    case FILES_UNLOCK = 'files.unlock';

    // Organization
    case ORG_MANAGE = 'organization.manage';
    case ORG_INVITE = 'organization.invite';
    case ORG_SETTINGS = 'organization.settings';

    // Project
    case PROJECT_VIEW = 'project.view';
    case PROJECT_CREATE = 'project.create';
    case PROJECT_UPDATE = 'project.update'; // e.g updating project details
    case PROJECT_MANAGE = 'project.manage'; // e.g managing project members
    case PROJECT_DELETE = 'project.delete';

    // Admin
    case ADMIN_SUPER = 'admin.super';
    case ADMIN_MANAGE = 'admin.manage';

    public static function grouped(): array
    {
        return [
            'todos' => [
                self::TODOS_VIEW,
                self::TODOS_CREATE,
                self::TODOS_UPDATE,
                self::TODOS_DELETE,
                self::TODOS_ASSIGN,
                self::TODOS_REVIEW,
                self::TODOS_COMMENT,
            ],
            'files' => [
                self::FILES_VIEW,
                self::FILES_UPLOAD,
                self::FILES_RENAME,
                self::FILES_DELETE,
                self::FILES_SHARE,
                self::FILES_DOWNLOAD,
                self::FILES_MOVE,
                self::FILES_LOCK,
                self::FILES_UNLOCK,
            ],
            'organization' => [
                self::ORG_MANAGE,
                self::ORG_INVITE,
                self::ORG_SETTINGS,
            ],
            'project' => [
                self::PROJECT_VIEW,
                self::PROJECT_CREATE,
                self::PROJECT_UPDATE,
                self::PROJECT_MANAGE,
                self::PROJECT_DELETE,
            ],
            'admin' => [
                self::ADMIN_SUPER,
                self::ADMIN_MANAGE,
            ],
        ];
    }

    public static function values(): array
    {
        return array_map(fn($perm) => $perm->value, self::cases());
    }
}
