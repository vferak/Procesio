<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess;

use Procesio\Domain\Process\Process;

class SubprocessData
{
    public function __construct(
        private string $name,
        private string $description,
        private ?Process $process,
        private ?Subprocess $comesFrom,
        private int $priority
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
     * @return Subprocess|null
     */
    public function getComesFrom(): ?Subprocess
    {
        return $this->comesFrom;
    }

    /**
     * @return Process|null
     */
    public function getProcess(): ?Process
    {
        return $this->process;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}
