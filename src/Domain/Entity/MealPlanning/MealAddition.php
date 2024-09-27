<?php

declare(strict_types=1);

namespace App\Domain\Entity\MealPlanning;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class MealAddition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $title
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
