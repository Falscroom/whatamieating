<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\MealPlanning\Meal;
use App\Domain\Entity\MealPlanning\MealAddition;
use App\Domain\Entity\MealPlanning\User;
use App\Domain\Enum\MealType;
use App\Domain\Shared\Utils\MappedArray;
use App\Domain\Shared\ValueObject\Date;
use App\Persistence\Repository\MealAdditionRepository;
use App\Persistence\Repository\MealRepository;
use App\Persistence\Repository\UserRepository;
use avadim\FastExcelReader\Excel;
use avadim\FastExcelReader\Sheet;
use Doctrine\ORM\EntityManagerInterface;

final class ExcelParser
{
    public const SHEETS_TO_PARSE = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт'];

    private const MEALS_ADDITIONS_COLUMNS = [
        ['C', 'D'],
        ['F', 'G'],
        ['H', 'I'],
        ['J', 'K'],
        ['L', 'M']
    ];

    private const MEAL_TYPE_MAP = [
        MealType::BREAKFAST->value => ['C', 'D', 'E'],
    ];

    private MappedArray $meals;

    private MappedArray $users;

    private array $additions;

    public function __construct(
        private readonly MealRepository $mealRepository,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly MealAdditionRepository $mealAdditionRepository,
    ) {}

    public function parse(string $filePath): void
    {
        $excel = Excel::open($filePath);

        foreach (self::SHEETS_TO_PARSE as $sheetName) {
            $sheet = $excel->getSheet($sheetName);
            $this->parseSheet($sheet);
        }
    }

    private function parseSheet(Sheet $sheet): void
    {

        $firstRow = $sheet->readNextRow();
        $date = Date::fromTimestamp($firstRow['B']);

        $sheet->readNextRow();
        $sheet->readNextRow();
        $sheet->readNextRow();
        $sheet->readNextRow();
        $row = $sheet->readNextRow();

        while(trim($row['B']) && $row['B'] !== 'Итого') {
            $user = $this->getCreateUser($row['B']);

            if ($juiceTitle = $row['E']) {
                $juice = $this->getCreateMeal($juiceTitle);
                $mealType = $this->getMealType('E');

                $user->chooseMeal($juice, $date, $mealType);
            };

            foreach (self::MEALS_ADDITIONS_COLUMNS as $pair) {
                [$mealC, $additionC] = $pair;

                if ($mealTitle = $row[$mealC]) {
                    $meal = $this->getCreateMeal($mealTitle);
                    $mealType = $this->getMealType($mealC);

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

        $this->entityManager->flush();
    }

    private function getMealType(string $column): MealType
    {
        if (in_array($column, self::MEAL_TYPE_MAP[MealType::BREAKFAST->value])) {
            return MealType::BREAKFAST;
        }

        return MealType::LUNCH;
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
        if (!isset($this->additions)) {
            $additions = $this->mealAdditionRepository->findAll(); //TODO n + 1

            foreach ($additions as $addition) {
                $this->additions[$addition->getMeal()->getTitle()][$addition->getTitle()] = $addition;
            }
        }

        if (!isset($this->additions[$meal->getTitle()][$additionTitle])) {
            $this->additions[$meal->getTitle()][$additionTitle] = new MealAddition($additionTitle, $meal);
        }

        return $this->additions[$meal->getTitle()][$additionTitle];
    }
}
