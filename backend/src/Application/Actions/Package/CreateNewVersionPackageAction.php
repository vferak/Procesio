<?php

namespace Procesio\Application\Actions\Package;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Package\PackageData;
use Psr\Http\Message\ResponseInterface as Response;

class CreateNewVersionPackageAction extends PackageAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();
        $processes = $request['processes'];

        try {
            $oldpackage = $this->packageFacade->getPackageByUuid($request['uuid']);
            $workspace = $this->workspaceFacade->getWorkspaceByUuid($request['workspace']);

            $packageData = new PackageData(
                $request['name'],
                $request['description'],
                $workspace,
                $oldpackage
            );

            $package = $this->packageFacade->createNewVersionPackage($packageData, $processes);

        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData(statusCode: 201);
    }
}
