<?php

declare(strict_types=1);

namespace App\Domain\Entity\MealPlanning;

use App\Domain\Enum\MealType;
use App\Domain\Shared\Entity\AggregateRoot;
use App\Domain\Shared\ValueObject\Date;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class User extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $fullName,

        #[ORM\OneToMany(targetEntity: MealChoice::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
        private Collection $mealChoices = new ArrayCollection()
    ) {}

    public function chooseMeal(Meal $meal, Collection $additions, Date $date, MealType $type): void
    {
        $mealChoice = new MealChoice($this, $meal, $additions, $date, $type);

        $this->mealChoices->add($mealChoice);
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getMealChoices(): Collection
    {
        return $this->mealChoices;
    }
}
