<?php

declare(strict_types=1);

namespace App\Domain\Entity\MealPlanning;

use App\Domain\Enum\MealType;
use App\Domain\Shared\ValueObject\Date;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class MealChoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mealChoices')]
        #[ORM\JoinColumn(nullable: false)]
        private User $user,

        #[ORM\ManyToOne(targetEntity: Meal::class, inversedBy: 'mealChoices')]
        #[ORM\JoinColumn(nullable: false)]
        private Meal $meal,

        /** @var Collection<int, MealAddition> */
        #[ORM\ManyToMany(targetEntity: MealAddition::class)]
        #[ORM\JoinTable(name: 'meal_choice_additions')]
        private Collection $additions,

        #[ORM\Column(type: 'date')]
        private Date $date,

        #[ORM\Column(type: 'string', enumType: MealType::class)]
        private MealType $mealType
    ) {}

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMeal(): Meal
    {
        return $this->meal;
    }

    public function getAdditions(): Collection
    {
        return $this->additions;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getMealType(): MealType
    {
        return $this->mealType;
    }
}
