<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace\Exceptions;

use Procesio\Domain\Exceptions\DomainException;
use Procesio\Domain\Project\Project;

class CouldNotDeleteProjectException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }

    /**
     * @param Project[] $projects
     */
    public static function createForProjects(array $projects): self
    {
        $projectUuids = [];
        foreach ($projects as $project) {
            $projectUuids[] = $project->getUuid();
        }

        return new self(
          sprintf(
              'Workspace could not be deleted because these projects exist: %s!',
              implode(', ', $projectUuids)
          )
        );
    }
}
