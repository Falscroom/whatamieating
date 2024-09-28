<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum MealType: string
{
    case BREAKFAST = 'Breakfast';

    case LUNCH = 'Lunch';

    /** @return string[] */
    public static function order(): array
    {
        return [self::BREAKFAST->value, self::LUNCH->value];
    }
}
