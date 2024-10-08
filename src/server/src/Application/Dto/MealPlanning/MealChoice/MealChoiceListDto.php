<?php

declare(strict_types=1);

namespace App\Application\Dto\MealPlanning\MealChoice;

use App\Domain\Entity\MealPlanning\User;
use App\Domain\Shared\ValueObject\Date;

final class MealChoiceListDto
{
    /** @param MealChoicesGroupedDto[] $mealChoicesWithType */
    private function __construct(
        public array $mealChoicesWithType,
        public string $date,
        public string $userFullName,
    ) {}

    public static function create(array $mealChoicesWithType, Date $date, User $user): self
    {
        return new self($mealChoicesWithType, (string) $date, $user->getFullName());
    }

    /**
     * @return array{
     *     mealChoices: array<int, array{
     *         type: string,
     *         choices: list<array{
     *             title: string
     *         }>,
     *     }>,
     *     date: string,
     *     userFullName: string
     * }
     */
    public function toArray(): array
    {
        $choices = array_map(fn (MealChoicesGroupedDto $choice) => $choice->toArray(), $this->mealChoicesWithType);

        return [
            'mealChoices' => $choices,
            'date' => $this->date,
            'userFullName' => $this->userFullName,
        ];
    }
}
