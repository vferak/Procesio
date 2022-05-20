<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Package;

use Psr\Http\Message\ResponseInterface as Response;

class ListPackagesAction extends PackageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $workspace_uuid = $this->resolveArg('id');
        $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspace_uuid);
        $packages = $this->packageFacade->findPackages($workspace);

        return $this->respondWithData($packages);
    }
}
