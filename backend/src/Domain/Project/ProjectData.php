<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

class ProjectData
{
    public function __construct(
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
