<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use Procesio\Domain\Process\Process;
use Procesio\Domain\Project\Project;
use Procesio\Domain\State\State;

class ProjectProcessData
{
    public function __construct(
        private Process $process,
        private Project $project,
        private State $state
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
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }


}
