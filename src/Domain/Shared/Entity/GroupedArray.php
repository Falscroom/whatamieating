<?php

declare(strict_types=1);

namespace App\Domain\Shared\Entity;

use InvalidArgumentException;

final readonly class GroupedArray
{
    private function __construct(private array $data) {}

    public static function fromObjectArray(array $objects, callable $groupByFn): self
    {
        $data = [];
        foreach ($objects as $object) {
            $data[$groupByFn($object)][] = $object;
        }

        return new self($data);
    }

    public function getSubArray(string $key): array
    {
        return $this->data[$key] ?? [];
    }
}
