<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class DriveId implements \Stringable
{
    private function __construct(private string $id) {}

    public static function fromUrl(string $url): DriveId
    {
        return new self();
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
