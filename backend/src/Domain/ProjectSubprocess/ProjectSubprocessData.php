<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use Procesio\Domain\Project\Project;
use Procesio\Domain\Subprocess\Subprocess;

class ProjectSubprocessData
{
    public function __construct(
        private Subprocess $subprocess,
        private Project $project,
        private string $state,
        private int $priority
    ) {
    }

    /**
     * @return Subprocess
     */
    public function getProcess(): Subprocess
    {
        return $this->subprocess;
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
