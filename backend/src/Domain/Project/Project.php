<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use DateTime;
use JsonSerializable;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Project\Exceptions\CouldNotCreateProjectException;
use Procesio\Domain\User\User;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Workspace\Workspace;

/**
 * @Entity
 * @Table(name="project")
 */
class Project implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    /** @Column(type="string", name="description") */
    private string $description;

    /** @Column(type="datetime", name="created_at") */
    private DateTime $createdAt;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\User\User")
     * @JoinColumn(name="created_by", referencedColumnName="uuid")
     */
    private User $createdBy;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Workspace\Workspace")
     * @JoinColumn(name="workspace_uuid", referencedColumnName="uuid")
     */
    private Workspace $workspace;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Package\Package")
     * @JoinColumn(name="package_uuid", referencedColumnName="uuid")
     */
    private Package $package;

    public function __construct(ProjectData $projectData)
    {
        $this->generateAndSetUuid();

        $invalidWorkspace = array_filter(
            $projectData->getCreatedBy()->getWorkspaces(),
            static function ($userWorkspace) use ($projectData) {
                return $userWorkspace->getUuid() === $projectData->getWorkspace()->getUuid();
            }
        );

        if (count($invalidWorkspace) === 0) {
            throw CouldNotCreateProjectException::createForUserWithDifferentWorkspace($projectData->getCreatedBy());
        }

        if ($projectData->getPackage()->getWorkspace()->getUuid() !== $projectData->getWorkspace()->getUuid()) {
            throw CouldNotCreateProjectException::createForPackageWithDifferentWorkspace($projectData->getPackage());
        }

        $this->description = $projectData->getDescription();
        $this->name = $projectData->getName();
        $this->createdAt = $projectData->getCreatedAt();
        $this->createdBy = $projectData->getCreatedBy();
        $this->workspace = $projectData->getWorkspace();
        $this->package = $projectData->getPackage();

        $this->edit($projectData);
    }

    public function edit(ProjectData $projectData): void
    {
        $this->name = $projectData->getName();
        $this->description = $projectData->getDescription();
        $this->createdBy = $projectData->getCreatedBy();
        $this->workspace = $projectData->getWorkspace();
        $this->package = $projectData->getPackage();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'createdAt' => $this->getCreatedAt(),
            'createdBy' => $this->getCreatedBy(),
            'workspace' => $this->getWorkspace(),
            'package' => $this->getPackage(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getWorkspace(): Workspace
    {
        return $this->workspace;
    }

    public function getPackage(): Package
    {
        return $this->package;
    }

    /*public function applyNewPackageToProject(Project $project, Package $newpackage): Project
    {

        return $project;
    }*/
}
