<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\MealPlanning\MealChoice\MealChoiceDto;
use App\Application\Dto\MealPlanning\MealChoice\MealChoiceListDto;
use App\Application\Dto\MealPlanning\MealChoice\MealChoicesGroupedDto;
use App\Domain\Entity\MealPlanning\MealChoice;
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
        $mealChoices = $this->repository->getMealChoices(4, $date);
        $mappedByType = MappedArray::objectArrayWithEnums($mealChoices, 'getMealType');

        $sortedMealChoicesDto = [];
        foreach (MealType::order() as $mealType) {
            $dtos = array_map(
                fn (MealChoice $choice) => MealChoiceDto::create($choice),
                $mappedByType->getSubArray($mealType)
            );

            $sortedMealChoicesDto[] = MealChoicesGroupedDto::create(MealType::from($mealType), $dtos);
        }

        return MealChoiceListDto::create($sortedMealChoicesDto, $date, $user);
    }
}
