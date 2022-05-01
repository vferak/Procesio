<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use JsonSerializable;
use Procesio\Domain\Process\Process;
use Procesio\Domain\Process\ProcessData;
use Procesio\Domain\Project\Project;
use Procesio\Domain\State\State;

/**
 * @Entity
 * @Table(name="project_processes")
 */
class ProjectProcess implements JsonSerializable
{
    /**
     * @Id
     * @ManyToOne(targetEntity="Procesio\Domain\Process\Process")
     * @JoinColumn(name="process_uuid", referencedColumnName="uuid")
     */
    private Process $process;

    /**
     * @Id
     * @ManyToOne(targetEntity="Procesio\Domain\Project\Project")
     * @JoinColumn(name="project_uuid", referencedColumnName="uuid")
     */
    private Project $project;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\State\State")
     * @JoinColumn(name="state", referencedColumnName="uuid")
     */
    private State $state;


    public function __construct(ProjectProcessData $projectProcessData)
    {
        $this->process = $projectProcessData->getProcess();
        $this->project = $projectProcessData->getProject();
        $this->state = $projectProcessData->getState();

        $this->changeState($projectProcessData);
    }

    public function jsonSerialize(): array
    {
        return [
            'process' => $this->getProcess(),
            'project' => $this->getProject(),
            'state' => $this->getState()
        ];
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

    public function changeState(ProjectProcessData $projectProcessData): void
    {
        $this->state = $projectProcessData->getState();
    }
}
