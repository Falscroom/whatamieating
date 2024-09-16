<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $fio,

        #[ORM\OneToMany(targetEntity: MealChoice::class, mappedBy: 'user')]
        private Collection $mealChoices = new ArrayCollection()
    ) {}

    public function getFio(): string
    {
        return $this->fio;
    }

    public function getMealChoices(): Collection
    {
        return $this->mealChoices;
    }
}
