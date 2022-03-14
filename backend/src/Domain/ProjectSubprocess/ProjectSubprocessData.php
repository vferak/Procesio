<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use Procesio\Domain\Project\Project;
use Procesio\Domain\State\State;
use Procesio\Domain\Subprocess\Subprocess;

class ProjectSubprocessData
{
    public function __construct(
        private Subprocess $subprocess,
        private Project $project,
        private State $state
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
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }


}
