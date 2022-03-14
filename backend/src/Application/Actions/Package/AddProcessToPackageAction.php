<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Package;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Psr\Http\Message\ResponseInterface as Response;

class AddProcessToPackageAction extends PackageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request->getParsedBody();
        $package_uuid = $request['package_uuid'];
        $process_uuid = $request['process_uuid'];

        try {
            $package= $this->packageFacade->getPackageByUuid($package_uuid);
            $process = $this->processFacade->getProcessByUuid($process_uuid);
            $package = $this->packageFacade->addProcessToPackage($package, $process);
        } catch (DomainObjectNotFoundException|CouldNotAddUserException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData($package);
    }
}
