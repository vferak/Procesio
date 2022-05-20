<?php

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Process\ProcessData;
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
        $priority = $request['priority'];
        $process = $this->processFacade->getProcessByUuid($request['process']);

        $comesFrom = $request['comesFrom'];

        if (empty($comesFrom)) {
            $comesFrom = null;
        } else {
            $comesFrom = $this->subprocessFacade->getSubprocessByUuid($comesFrom);
        }

        $subprocessData = new SubprocessData($name, $description, $process, $comesFrom, $priority);

        $this->subprocessFacade->createSubprocess($subprocessData);

        $processData = new ProcessData($process->getName(), $process->getDescription(), $process);
        $this->processFacade->createProcess($processData);

        return $this->respondWithData(statusCode: 201);
    }
}