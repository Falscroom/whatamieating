<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Stringable;

final class Date implements Stringable
{
    private DateTimeInterface $date;

    private function __construct(DateTimeInterface $date)
    {
        $this->date = (clone $date)->setTime(0, 0);
    }

    public static function today(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function fromDateTime(DateTimeInterface $dateTime): self
    {
        return new self($dateTime);
    }

    public static function fromTimestamp(int $timestamp): self
    {
        return new self((new DateTime())->setTimestamp($timestamp));
    }

    public function toDateTime(): DateTimeInterface
    {
        return $this->date;
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}
