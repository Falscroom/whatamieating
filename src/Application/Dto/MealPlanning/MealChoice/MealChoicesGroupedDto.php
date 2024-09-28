<?php

declare(strict_types=1);

namespace App\Application\Dto\MealPlanning\MealChoice;

use App\Domain\Enum\MealType;

final class MealChoicesGroupedDto
{
    /** @param MealChoiceDto[] $choices */
    private function __construct(public string $type, public array $choices) {}

    /** @param MealChoiceDto[] $choices */
    public static function create(MealType $type, array $choices): self
    {
        return new self($type->value, $choices);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'choices' => array_map(fn (MealChoiceDto $choice) => $choice->toArray(), $this->choices),
        ];
    }
}
