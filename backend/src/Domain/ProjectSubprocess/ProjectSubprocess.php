<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use JsonSerializable;
use Procesio\Domain\Project\Project;
use Procesio\Domain\State\State;
use Procesio\Domain\Subprocess\Subprocess;

/**
 * @Entity
 * @Table(name="project_subprocesses")
 */
class ProjectSubprocess implements JsonSerializable
{
    /**
     * @Id
     * @ManyToOne(targetEntity="Procesio\Domain\Subprocess\Subprocess")
     * @JoinColumn(name="subprocess_uuid", referencedColumnName="uuid")
     */
    private Subprocess $subprocess;

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


    public function __construct(ProjectSubprocessData $projectSubprocessData)
    {
        $this->subprocess = $projectSubprocessData->getProcess();
        $this->project = $projectSubprocessData->getProject();
        $this->state = $projectSubprocessData->getState();

    }

    public function jsonSerialize(): array
    {
        return [
            'subprocess' => $this->getSubprocess(),
            'project' => $this->getProject(),
            'state' => $this->getState()
        ];
    }

    /**
     * @return Subprocess
     */
    public function getSubprocess(): Subprocess
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
