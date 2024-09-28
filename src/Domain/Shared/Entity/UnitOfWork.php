<?php

declare(strict_types=1);

namespace App\Domain\Shared\Entity;

final class UnitOfWork
{
    //TODO no events for now :(
    public function commit(AggregateRoot $root): void
    {
        //todo persist
    }

    public function save(AggregateRoot $root): void
    {
        //TODO save entity to db

        //TODO outbox?

        //TODO dispatch domain events
    }
}
