<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use Procesio\Domain\Process\Process;
use Procesio\Domain\Project\Project;

class ProjectProcessData
{
    public function __construct(
        private Process $process,
        private Project $project,
        private string $state,
        private int $priority,
    ) {
    }

    /**
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->process;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}
