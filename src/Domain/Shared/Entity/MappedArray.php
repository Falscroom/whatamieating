<?php

declare(strict_types=1);

namespace App\Domain\Shared\Entity;

use InvalidArgumentException;

final class MappedArray
{
    private function __construct(private array $data) {}

    public static function fromObjectArray(array $objects, callable $keyFn): self
    {
        $data = [];
        foreach ($objects as $object) {
            $data[$keyFn($object)] = $object;
        }

        return new self($data);
    }

    public function get(int|string $key): ?object
    {
        return $this->data[$key] ?? null;
    }

    public function add(int|string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }
}
