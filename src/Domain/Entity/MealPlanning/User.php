<?php

declare(strict_types=1);

namespace App\Domain\Entity\MealPlanning;

use App\Domain\Enum\MealType;
use App\Domain\Shared\Entity\AggregateRoot;
use App\Domain\Shared\ValueObject\Date;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'app_user')]
class User extends AggregateRoot implements UserInterface
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

    public function chooseMeal(Meal $meal, Date $date, MealType $type): MealChoice
    {
        $mealChoice = new MealChoice($this, $meal, $date, $type);

        $this->mealChoices->add($mealChoice);

        return $mealChoice;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getMealChoices(): Collection
    {
        return $this->mealChoices;
    }

    public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->id;
    }
}
