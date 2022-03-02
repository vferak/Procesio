<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use DateTime;
use Procesio\Domain\User\User;

class ProjectData
{
    public function __construct(
        private string $name,
        private string $description,
        private User $createdBy,
        private DateTime $createdAt,
        private $workspace,
        private $package,
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

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @return mixed
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }
}
