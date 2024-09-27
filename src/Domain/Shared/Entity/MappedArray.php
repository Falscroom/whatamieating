<?php

declare(strict_types=1);

namespace App\Domain\Shared\Entity;

use InvalidArgumentException;

final class MappedArray
{
    private function __construct(private array $data) {}

    public static function objectArrayWithEnums(array $objects, string $keyMethodName): self
    {
        $data = [];
        foreach ($objects as $object) {
            self::valid($object, $keyMethodName);
            $data[(string) $object->{$keyMethodName}()->value][] = $object;
        }

        return new self($data);
    }

    public function getSubArray(string $key): array
    {
        return $this->data[$key] ?? [];
    }

    private static function valid(object $object, string $keyMethodName): void
    {
        if (!method_exists($object, $keyMethodName)) {
            throw new InvalidArgumentException(sprintf('Method %s does not exist', $keyMethodName));
        }
    }
}
