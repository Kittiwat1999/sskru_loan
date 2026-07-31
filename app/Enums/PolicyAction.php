<?php

namespace App\Enums;

enum PolicyAction: string
{
    case CREATE = 'create';

    case UPDATE = 'update';

    case PUBLISH = 'publish';

    case ARCHIVE = 'archive';

    case RESTORE = 'restore';
}