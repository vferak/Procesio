<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Package;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Package\PackageData;
use Psr\Http\Message\ResponseInterface as Response;

class EditPackageAction extends PackageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $package = null;
        $request = $this->getFormData();
        try {
            $package = $this->packageFacade->getPackageByUuid($request->uuid);

            $workspace = $this->workspaceFacade->getWorkspaceByUuid($request->workspace);
            $comesFrom = $request->comesFrom ?? null;

            if ($comesFrom !== null) {
                $comesFrom = $this->packageFacade->getPackageByUuid($comesFrom);
            }

            $packageData = new PackageData(
                $request->name ?? $package->getName(),
                $request->description ?? $package->getDescription(),
                $workspace,
                $comesFrom
            );

            $this->packageFacade->editPackage($package, $packageData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData($package);
    }
}
