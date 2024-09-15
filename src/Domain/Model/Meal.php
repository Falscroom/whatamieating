<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Enum\MealType;
use App\Domain\ValueObject\Date;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $title,
        #[ORM\Column]
        private User $user,
        #[ORM\Column]
        private Date $date,
        #[ORM\Column]
        private MealType $type,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getType(): MealType
    {
        return $this->type;
    }
}
