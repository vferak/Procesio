<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\ProcessPackage;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Package\PackageData;
use Procesio\Domain\ProcessPackage\ProcessPackageData;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Psr\Http\Message\ResponseInterface as Response;

class AddProcessToPackageAction extends ProcessPackageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request->getParsedBody();
        $package_uuid = $request['package_uuid'];
        $processes = $request['processes'];

        try {
            $package = $this->packageFacade->getPackageByUuid($package_uuid);

            foreach ($processes as $processArray) {
                $process = $this->processFacade->getProcessByUuid($processArray["process_uuid"]);
                $processPackageData = new ProcessPackageData($process, $package, (int)($processArray["priority"]));
                $this->processPackageFacade->addProcessToPackage($processPackageData);
            }

            $packageData = new PackageData(
                $package->getName(),
                $package->getDescription(),
                $package->getWorkspace(),
                $package
            );

            $package = $this->packageFacade->createPackage($packageData);
        } catch (DomainObjectNotFoundException | CouldNotAddUserException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData($package);
    }
}
