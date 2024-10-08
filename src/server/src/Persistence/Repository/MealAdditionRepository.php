<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Domain\Entity\MealPlanning\MealAddition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MealAddition>
 *
 * @method null|MealAddition find($id, $lockMode = null, $lockVersion = null)
 * @method null|MealAddition findOneBy(array $criteria, array $orderBy = null)
 * @method MealAddition[] findAll()
 * @method MealAddition[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MealAdditionRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, MealAddition::class);
    }
}
