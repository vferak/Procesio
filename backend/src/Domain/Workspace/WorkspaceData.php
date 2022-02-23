<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;

class WorkspaceData
{
    public function __construct(
        private string $name
        //private string $password
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /*public function getPassword(): string
    {
        return $this->password;
    }*/
}
