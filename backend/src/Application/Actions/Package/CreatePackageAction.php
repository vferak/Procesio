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
        //prijmou data z requestu a poslat do facade nic se zde s nima nedela
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        //$password = $request['password'];
        $packageData = new PackageData($name);

        $this->packageFacade->createWorkspace($packageData);

        return $this->respondWithData(statusCode: 201);


        //zavolat facade
    }
}