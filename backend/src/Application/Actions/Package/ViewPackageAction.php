<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Package;

use Psr\Http\Message\ResponseInterface as Response;

class ViewPackageAction extends PackageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $packageId = $this->resolveArg('id');
        $package = $this->packageFacade->getPackageByUuid($packageId);
        $this->logger->info("User of id {$packageId} was viewed.");

        return $this->respondWithData($package);
    }
}
