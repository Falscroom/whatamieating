<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum MealType: string
{
    case BREAKFAST = 'breakfast';

    case LUNCH = 'lunch';
}
