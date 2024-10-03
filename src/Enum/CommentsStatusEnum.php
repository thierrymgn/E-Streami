<?php

declare(strict_types=1);

namespace App\Enum;

enum CommentsStatusEnum: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}