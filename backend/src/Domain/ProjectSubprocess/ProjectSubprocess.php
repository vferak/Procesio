<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use JsonSerializable;
use Procesio\Application\States\State;
use Procesio\Domain\Project\Project;
use Procesio\Domain\Subprocess\Subprocess;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectProcessRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectSubprocessRepository;

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


    /** @Column(type="string") */
    private string $state;

    /** @Column(type="integer") */
    private int $priority;


    public function __construct(ProjectSubprocessData $projectSubprocessData)
    {
        $this->subprocess = $projectSubprocessData->getProcess();
        $this->project = $projectSubprocessData->getProject();
        $this->state = $projectSubprocessData->getState();
        $this->priority = $projectSubprocessData->getPriority();

        $this->changeState($projectSubprocessData);
    }

    public function jsonSerialize(): array
    {
        return [
            'subprocess' => $this->getSubprocess(),
            'project' => $this->getProject(),
            'state' => $this->getState(),
            'priority' => $this->getPriority()
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
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    public function changeState(ProjectSubprocessData $projectSubprocessData): void
    {
        $this->state = $projectSubprocessData->getState();
    }

    public function delete(
        ProjectSubprocessRepository $projectSubprocessRepository
    ): void {

        $projectSubprocessRepository->deleteProjectSubprocess($this);
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
