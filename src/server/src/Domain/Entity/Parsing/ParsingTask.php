<?php

declare(strict_types=1);

namespace App\Domain\Entity\Parsing;

use App\Domain\Enum\ParsingStatus;
use App\Domain\Shared\Entity\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

final class ParsingTask extends AggregateRoot
{
    public function __construct(
        #[ORM\Column]
        private ParsingStatus $status = ParsingStatus::NEW,
    ) {}

    public function start(): void
    {
        $this->status = ParsingStatus::IN_PROGRESS;
    }

    public function finish(): void
    {
        $this->status = ParsingStatus::FINISHED;
    }

    public function getStatus(): ParsingStatus
    {
        return $this->status;
    }
}
