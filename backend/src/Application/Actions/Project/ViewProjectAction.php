<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Project;

use Psr\Http\Message\ResponseInterface as Response;

class ViewProjectAction extends ProjectAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $projectId = $this->resolveArg('id');
        $project = $this->projectFacade->getProjectByUuid($projectId);

        $this->logger->info("Project of id {$projectId} was viewed.");

        return $this->respondWithData($project);
    }
}
