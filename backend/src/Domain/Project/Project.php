<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use DateTime;
use JsonSerializable;
use Procesio\Domain\User\User;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Package\Package;
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
        $this->description = $projectData->getDescription();
        $this->name = $projectData->getName();
        $this->createdAt = $projectData->getCreatedAt();
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @return mixed
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }


}
