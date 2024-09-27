<?php

declare(strict_types=1);

namespace App\Application\Dto\MealPlanning\MealChoice;

use App\Domain\Entity\MealPlanning\MealChoice;

final class MealChoiceDto
{
    private function __construct(public string $title) {}

    public static function create(MealChoice $mealChoice): self
    {
        return new self($mealChoice->getTitleWithAdditions());
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
