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
        $packages = $this->packageFacade->findPackages();

        return $this->respondWithData($packages);
    }
}
