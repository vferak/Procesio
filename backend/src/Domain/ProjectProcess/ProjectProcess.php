<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use JsonSerializable;
use Procesio\Application\States\State;
use Procesio\Domain\Process\Process;
use Procesio\Domain\Project\Project;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectProcessRepository;

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

    /** @Column(type="string") */
    private string $state;

    /** @Column(type="integer") */
    private int $priority;


    public function __construct(ProjectProcessData $projectProcessData)
    {
        $this->process = $projectProcessData->getProcess();
        $this->project = $projectProcessData->getProject();
        $this->state = $projectProcessData->getState();
        $this->priority = $projectProcessData->getPriority();

        $this->changeState($projectProcessData);
    }

    public function jsonSerialize(): array
    {
        return [
            'process' => $this->getProcess(),
            'project' => $this->getProject(),
            'state' => $this->getState(),
            'priority' => $this->getPriority()
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
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    public function changeState(ProjectProcessData $projectProcessData): void
    {
        $this->state = $projectProcessData->getState();
    }

    public function delete(
        ProjectProcessRepository $projectProcessRepository
    ): void {

        $projectProcessRepository->deleteProjectProcess($this);
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        if (!in_array($state, State::getAllStates())) {
            throw new \InvalidArgumentException("Neplatná hodnota");
        }
        $this->state = $state;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}
