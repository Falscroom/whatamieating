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
