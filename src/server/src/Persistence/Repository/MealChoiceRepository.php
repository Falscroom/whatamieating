<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Domain\Entity\MealPlanning\MealChoice;
use App\Domain\Shared\ValueObject\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MealChoice>
 *
 * @method null|MealChoice find($id, $lockMode = null, $lockVersion = null)
 * @method null|MealChoice findOneBy(array $criteria, array $orderBy = null)
 * @method MealChoice[] findAll()
 * @method MealChoice[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MealChoiceRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, MealChoice::class);
    }

    /** @return MealChoice[] */
    public function getMealChoices(int $userId, Date $date): array
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
