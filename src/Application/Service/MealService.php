<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\MealPlanning\MealChoice\MealChoiceListDto;
use App\Application\Dto\MealPlanning\MealChoice\MealChoicesGroupedDto;
use App\Domain\Entity\MealPlanning\User;
use App\Domain\Enum\MealType;
use App\Domain\Shared\Entity\MappedArray;
use App\Domain\Shared\ValueObject\Date;
use App\Persistence\Repository\MealChoiceRepository;

final readonly class MealService
{
    public function __construct(private MealChoiceRepository $repository) {}

    public function getMealChoices(User $user, Date $date): MealChoiceListDto
    {
        $mealChoices = $this->repository->getMealChoices($user->getId(), $date);
        $mappedByType = MappedArray::objectArrayWithEnums($mealChoices, 'getMealType');

        $sortedMealChoicesDto = [];
        foreach ([MealType::BREAKFAST->value, MealType::LUNCH->value] as $mealType) {
            $sortedMealChoicesDto[] = new MealChoicesGroupedDto(
                MealType::from($mealType),
                $mappedByType->getSubArray($mealType),
            );
        }

        return new MealChoiceListDto($sortedMealChoicesDto);
    }
}
