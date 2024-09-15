<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;
use Stringable;

final class Date implements Stringable
{
    private DateTimeImmutable $date;

    private function __construct(DateTimeImmutable $date)
    {
        $this->date = $date->setTime(0, 0);
    }

    public static function fromDateTime(DateTimeImmutable $dateTime): self
    {
        return new self($dateTime);
    }

    public static function fromString(string $dateString): self
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $dateString);

        if ($date === false) {
            throw new InvalidArgumentException("Invalid date format: $dateString");
        }

        return new self($date);
    }

    public function toDateTimeImmutable(): DateTimeImmutable
    {
        return $this->date;
    }

    public function equals(self $other): bool
    {
        return $this->date === $other->date;
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}
