<?php

namespace Procesio\Application\Actions\Project;




use Procesio\Domain\Project\ProjectData;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateProjectAction extends ProjectAction
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
        $projectData = new ProjectData($name);

        $this->projectFacade->createProject($projectData);

        return $this->respondWithData(statusCode: 201);


        //zavolat facade
    }
}