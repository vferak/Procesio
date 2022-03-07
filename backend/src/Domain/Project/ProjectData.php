<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use DateTime;
use Procesio\Domain\Package\Package;
use Procesio\Domain\User\User;
use Procesio\Domain\Workspace\Workspace;

class ProjectData
{
    public function __construct(
        private string $name,
        private string $description,
        private User $createdBy,
        private DateTime $createdAt,
        private Workspace $workspace,
        private Package $package,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getPackage(): Package
    {
        return $this->package;
    }

    public function getWorkspace(): Workspace
    {
        return $this->workspace;
    }
}
