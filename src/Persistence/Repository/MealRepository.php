<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Domain\Entity\MealPlanning\Meal;
use App\Domain\Shared\ValueObject\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meal>
 *
 * @method null|Meal find($id, $lockMode = null, $lockVersion = null)
 * @method null|Meal findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[] findAll()
 * @method Meal[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MealRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, Meal::class);
    }

    /** @return Meal[] */
    public function getMeals(int $userId, Date $date): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.user = :user')
            ->andWhere('m.date = :date')
            ->setParameter('user', $userId)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }
}
