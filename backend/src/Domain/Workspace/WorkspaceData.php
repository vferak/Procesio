<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;

use Doctrine\Common\Collections\ArrayCollection;
use Procesio\Domain\User\User;

class WorkspaceData
{
    public function __construct(
        private string $name,
        private string $description,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

}
