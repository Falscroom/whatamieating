<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\MealPlanning\Meal;
use App\Domain\Entity\MealPlanning\MealAddition;
use App\Domain\Entity\MealPlanning\User;
use App\Domain\Enum\MealType;
use App\Domain\Shared\ValueObject\Date;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SeedDatabaseCommand extends Command
{
    protected static $defaultName = 'app:seed-database';

    public function __construct(private EntityManagerInterface $entityManager) //TODO repository
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Seed the database with initial data including at least 3 users and 5 meals.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Start transaction
        $this->entityManager->beginTransaction();

        try {
            // Seed Users
            $user1 = new User('John Doe');
            $user2 = new User('Jane Smith');
            $user3 = new User('Alice Johnson');

            // Seed Meals
            $meal1 = new Meal('Pasta');
            $meal2 = new Meal('Salad');
            $meal3 = new Meal('Burger');
            $meal4 = new Meal('Sushi');
            $meal5 = new Meal('Pizza');
            $this->entityManager->persist($meal1);
            $this->entityManager->persist($meal2);
            $this->entityManager->persist($meal3);
            $this->entityManager->persist($meal4);
            $this->entityManager->persist($meal5);

            // Seed Meal Additions
            $addition1 = new MealAddition('Extra Cheese');
            $addition2 = new MealAddition('Spicy Sauce');
            $addition3 = new MealAddition('Bacon');
            $addition4 = new MealAddition('Avocado');
            $addition5 = new MealAddition('Garlic Bread');
            $this->entityManager->persist($addition1);
            $this->entityManager->persist($addition2);
            $this->entityManager->persist($addition3);
            $this->entityManager->persist($addition4);
            $this->entityManager->persist($addition5);

            // Use the `chooseMeal` method to assign meals to users
            $user1->chooseMeal(
                $meal1,
                new ArrayCollection([$addition1, $addition2]),
                Date::fromDateTime(new DateTimeImmutable()),
                MealType::BREAKFAST
            );
            $user1->chooseMeal(
                $meal4,
                new ArrayCollection([$addition3, $addition4]),
                Date::fromDateTime(new DateTimeImmutable()),
                MealType::LUNCH
            );

            $user2->chooseMeal(
                $meal2,
                new ArrayCollection([$addition2, $addition5]),
                Date::fromDateTime(new DateTimeImmutable()),
                MealType::LUNCH
            );
            $user2->chooseMeal(
                $meal5,
                new ArrayCollection([$addition1, $addition3]),
                Date::fromDateTime(new DateTimeImmutable()),
                MealType::BREAKFAST
            );

            $user3->chooseMeal(
                $meal3,
                new ArrayCollection([$addition4, $addition5]),
                Date::fromDateTime(new DateTimeImmutable()),
                MealType::BREAKFAST
            );

            // Persist Users
            $this->entityManager->persist($user1);
            $this->entityManager->persist($user2);
            $this->entityManager->persist($user3);

            // Commit transaction
            $this->entityManager->flush();
            $this->entityManager->commit();

            $io->success('Database seeding complete with 3 users, 5 meals, and meal choices.');
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            $io->error('Error occurred: ' . $e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
