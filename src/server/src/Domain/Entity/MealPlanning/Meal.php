<?php

declare(strict_types=1);

namespace App\Domain\Entity\MealPlanning;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $title,

        #[ORM\OneToMany(targetEntity: MealAddition::class, mappedBy: 'meal', cascade: ['persist', 'remove'])]
        private Collection $additions = new ArrayCollection(),

        #[ORM\OneToMany(targetEntity: MealChoice::class, mappedBy: 'meal')]
        private Collection $mealChoices = new ArrayCollection(),
    ) {}

    public function addAddition(MealAddition $addition): self
    {
        $this->additions->add($addition);

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAdditions(): Collection
    {
        return $this->additions;
    }

    public function getMealChoices(): Collection
    {
        return $this->mealChoices;
    }
}
