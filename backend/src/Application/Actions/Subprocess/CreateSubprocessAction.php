<?php

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Subprocess\SubprocessData;
use Psr\Http\Message\ResponseInterface as Response;

class CreateSubprocessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        $description = $request['description'];
        $process = $this->processFacade->getProcessByUuid($request['process']);

        $comesFrom = $request['comesFrom'];

        if (empty($comesFrom)) {
            $comesFrom = null;
        } else {
            $comesFrom = $this->subprocessFacade->getSubprocessByUuid($comesFrom);
        }


        $subprocessData = new SubprocessData($name,$description,$process,$comesFrom);

        $this->subprocessFacade->createSubprocess($subprocessData);

        return $this->respondWithData(statusCode: 201);
    }
}
