<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\MealPlanning\Meal;
use App\Domain\Entity\MealPlanning\MealAddition;
use App\Domain\Entity\MealPlanning\User;
use App\Domain\Enum\MealType;
use App\Domain\Shared\Entity\MappedArray;
use App\Domain\Shared\ValueObject\Date;
use App\Persistence\Repository\MealAdditionRepository;
use App\Persistence\Repository\MealRepository;
use App\Persistence\Repository\UserRepository;
use avadim\FastExcelReader\Excel;
use Doctrine\ORM\EntityManagerInterface;

final class ExcelParser
{
    private const MEALS_ADDITIONS_COLUMNS = [
        ['C', 'D'],
        ['F', 'G'],
        ['H', 'I'],
        ['J', 'K'],
        ['L', 'M']
    ];

    private const MEAL_TYPE_MAP = [
        'C' => MealType::BREAKFAST,
        'D' => MealType::BREAKFAST,
        'E' => MealType::BREAKFAST,
    ];

    private MappedArray $meals;

    private MappedArray $users;

    private array $additions;

    public function __construct(
        private MealRepository $mealRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private MealAdditionRepository $mealAdditionRepository,
    ) {}

    public function parse(string $filePath): void
    {
        $excel = Excel::open($filePath);
        $sheet = $excel->getSheet('Пн');

        $firstRow = $sheet->readNextRow();
        $date = Date::fromTimestamp($firstRow['B']);

        $sheet->readNextRow();
        $sheet->readNextRow();
        $mealTypesRow = $sheet->readNextRow();
        $sheet->readNextRow();

        $row = $sheet->readNextRow();
        while($row['B']) {
            $user = $this->getCreateUser($row['B']);

            if ($juiceTitle = $row['E']) {
                $juice = $this->getCreateMeal($juiceTitle);
                $mealType = self::MEAL_TYPE_MAP[$mealTypesRow['E']];

                $user->chooseMeal($juice, $date, $mealType);
            };

            foreach (self::MEALS_ADDITIONS_COLUMNS as $pair) {
                [$mealC, $additionC] = $pair;

                if ($mealTitle = $row[$mealC]) {
                    $meal = $this->getCreateMeal($mealTitle);
                    $mealType = self::MEAL_TYPE_MAP[$mealTypesRow[$mealC]];

                    $mealChoice = $user->chooseMeal($meal, $date, $mealType);

                    if ($additionTitle = $row[$additionC]) {
                        $addition = $this->getCreateAddition($meal, $additionTitle);
                        $mealChoice->addAddition($addition);
                    }
                }
            }

            $this->entityManager->persist($user);
            $row = $sheet->readNextRow();
        }
    }

    private function getCreateMeal(string $mealTitle): Meal
    {
        if (!isset($this->meals)) {
            $meals = $this->mealRepository->findAll();
            $this->meals = MappedArray::fromObjectArray($meals, fn (Meal $m) => $m->getTitle());
        }

        if (!$this->meals->get($mealTitle)) {
            $this->meals->add($mealTitle, new Meal($mealTitle));
        }

        return $this->meals->get($mealTitle);
    }

    private function getCreateUser(string $fullName): User
    {
        if (!isset($this->users)) {
            $users = $this->userRepository->findAll();
            $this->users = MappedArray::fromObjectArray($users, fn (User $m) => $m->getFullName());
        }

        if (!$this->users->get($fullName)) {
            $this->users->add($fullName, new User($fullName));
        }

        return $this->users->get($fullName);
    }

    private function getCreateAddition(Meal $meal, string $additionTitle): MealAddition
    {
        if (!isset($this->meals)) {
            $additions = $this->mealAdditionRepository->findAll(); //TODO n + 1

            foreach ($additions as $addition) {
                $this->additions[$addition->getMeal()->getTitle()][$addition->getTitle()] = $addition;
            }
        }

        if (!isset($this->additions[$meal->getTitle()][$meal->getTitle()])) {
            $this->additions[$meal->getTitle()][$meal->getTitle()] = new MealAddition($meal->getTitle(), $meal);
        }

        return $this->additions[$meal->getTitle()][$meal->getTitle()];
    }
}
