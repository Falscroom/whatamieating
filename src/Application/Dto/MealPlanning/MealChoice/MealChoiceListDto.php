<?php

declare(strict_types=1);

namespace App\Application\Dto\MealPlanning\MealChoice;

final class MealChoiceListDto
{
    /** @param MealChoicesGroupedDto[] $mealChoicesWithType */
    public function __construct(public array $mealChoicesWithType) {}

    public function toArray(): array
    {
        return array_map(fn (MealChoicesGroupedDto $choice) => $choice->toArray(), $this->mealChoicesWithType);
    }
}
