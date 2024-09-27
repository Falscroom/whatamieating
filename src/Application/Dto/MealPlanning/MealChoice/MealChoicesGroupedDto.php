<?php

declare(strict_types=1);

namespace App\Application\Dto\MealPlanning\MealChoice;

use App\Domain\Entity\MealPlanning\MealChoice;
use App\Domain\Enum\MealType;

final class MealChoicesGroupedDto
{
    /** @param MealChoiceDto[] $choices */
    public function __construct(public MealType $type, public array $choices) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'choices' => array_map(fn (MealChoiceDto $choice) => $choice->toArray(), $this->choices),
        ];
    }
}
