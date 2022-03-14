<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

class ProcessData
{
    public function __construct(
        private string $name,
        private string $description,
        private ?Process $comesFrom
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Process|null
     */
    public function getComesFrom(): mixed
    {
        return $this->comesFrom;
    }
}
