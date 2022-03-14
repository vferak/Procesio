<?php

namespace Procesio\Application\Actions\Package;

use Procesio\Domain\Package\PackageData;
use Psr\Http\Message\ResponseInterface as Response;

class CreatePackageAction extends PackageAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        $description = $request['description'];
        $workspace = $this->workspaceFacade->getWorkspaceByUuid($request['workspace']);
        $comesFrom = $request['comesFrom'] ?? null;

        if ($comesFrom !== null) {
            $comesFrom = $this->packageFacade->getPackageByUuid($comesFrom);
        }

        $packageData = new PackageData($name, $description, $workspace, $comesFrom);

        $this->packageFacade->createWorkspace($packageData);

        return $this->respondWithData(statusCode: 201);
    }
}
