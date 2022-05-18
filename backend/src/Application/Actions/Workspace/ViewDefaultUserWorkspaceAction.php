<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Psr\Http\Message\ResponseInterface as Response;

class ViewDefaultUserWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userUuid = $this->resolveArg('id');
        $workspace = $this->workspaceFacade->getDefaultUserWorkspaceByUuid($userUuid);


        return $this->respondWithData($workspace);
    }
}
