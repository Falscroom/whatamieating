<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ParsingStatus: string
{
    case NEW = 'new';

    CASE IN_PROGRESS = 'in_progress';

    case FINISHED = 'finished';
}
