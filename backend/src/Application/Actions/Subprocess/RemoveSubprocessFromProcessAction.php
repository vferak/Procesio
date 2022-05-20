<?php

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Process\ProcessData;
use Procesio\Domain\Subprocess\SubprocessData;
use Psr\Http\Message\ResponseInterface as Response;

class RemoveSubprocessFromProcessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $subprocessUuid = $this->resolveArg('id');
        $subprocess = $this->subprocessFacade->getSubprocessByUuid($subprocessUuid);

        $subprocessData = new SubprocessData($subprocess->getName(), $subprocess->getDescription(), null, $subprocess, $subprocess->getPriority());
        $this->subprocessFacade->createSubprocess($subprocessData);

        $process = $subprocess->getProcess();
        $processData = new ProcessData($process?->getName(), $process?->getDescription(), $process);
        $this->processFacade->createProcess($processData);

        return $this->respondWithData(statusCode: 201);
    }
}