<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use InvalidArgumentException;

final readonly class DriveId implements \Stringable
{
    private function __construct(private string $id) {}

    public static function fromUrl(string $url): DriveId
    {
        if (preg_match('/\/d\/([a-zA-Z0-9-_]+)\//', $url, $matches)) {
            return new self($matches[1]);
        }

        throw new InvalidArgumentException('Invalid url');
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
