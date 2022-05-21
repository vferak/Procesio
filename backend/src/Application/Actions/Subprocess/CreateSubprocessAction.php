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

        $process = $this->processFacade->createNewProcessVersion($process);

        $subprocessData = new SubprocessData($name, $description, $process, null, $priority);
        $this->subprocessFacade->createSubprocess($subprocessData);

        return $this->respondWithData($process, 201);
    }
}
