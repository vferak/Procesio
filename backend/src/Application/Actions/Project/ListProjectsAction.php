<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Project;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Project\ProjectData;
use Psr\Http\Message\ResponseInterface as Response;

class ListProjectsAction extends ProjectAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $workspace_uuid = $this->resolveArg('id');
        $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspace_uuid);
        $projects = $this->projectFacade->findProjects($workspace);

        return $this->respondWithData($projects);
    }
}
