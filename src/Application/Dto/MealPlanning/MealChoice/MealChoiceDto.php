<?php

declare(strict_types=1);

namespace App\Application\Dto\MealPlanning\MealChoice;

final class MealChoiceDto
{
    public function __construct(public string $title) {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
