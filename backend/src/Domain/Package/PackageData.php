<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Procesio\Domain\Workspace\Workspace;

class PackageData
{
    public function __construct(
        private string $name,
        private string $description,
        private Workspace $workspace,
        private Package $comesFrom
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getComesFrom(): Package
    {
        return $this->comesFrom;
    }

    public function getWorkspace(): Workspace
    {
        return $this->workspace;
    }
}
