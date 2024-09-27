<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Domain\Entity\MealPlanning\MealChoice;
use App\Domain\Shared\ValueObject\Date;

final class MealChoiceRepository
{
    /** @return MealChoice[] */
    public function getMealChoices(int $userId, Date $date): array
    {

    }
}
