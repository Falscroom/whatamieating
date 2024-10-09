<?php

declare(strict_types=1);

namespace App\Domain\Shared\Entity;

class AggregateRoot
{
    private array $events = [];

    public function raiseEvent(object $event):  void
    {
        $this->events[] = $event;
    }

    public function pullEvents(): array
    {
        return $this->events;
    }
}
