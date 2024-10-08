<?php

declare(strict_types=1);

namespace App\Persistence\DBAL;

use App\Domain\Shared\ValueObject\Date;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use InvalidArgumentException;

final class DateType extends DateTimeImmutableType
{
    public const DATE_TYPE = 'date';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Date
    {
        if ($value === null) {
            return null;
        }

        $dateTime = DateTimeImmutable::createFromFormat($platform->getDateTimeFormatString(), $value);

        if ($dateTime !== false) {
            return Date::fromDateTime($dateTime);
        }

        throw new InvalidArgumentException('Invalid DB value for DateType');
    }

    /** @param Date $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Date) {
            return $value->toDateTime()->format($platform->getDateTimeFormatString());
        }

        throw new InvalidArgumentException('Invalid PHP value for DateType');
    }

    public function getName(): string
    {
        return self::DATE_TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
