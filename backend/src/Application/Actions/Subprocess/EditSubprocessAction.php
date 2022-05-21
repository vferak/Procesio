<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Process\ProcessData;
use Procesio\Domain\Subprocess\SubprocessData;
use Psr\Http\Message\ResponseInterface as Response;

class EditSubprocessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $subprocess = null;
        $request = $this->request->getParsedBody();
        $subprocessUuid = $this->resolveArg('id');

        try {
            $subprocess = $this->subprocessFacade->getSubprocessByUuid($subprocessUuid);

            $process = $subprocess->getProcess();
            $processData = new ProcessData($process?->getName(), $process?->getDescription(), $process);
            $process = $this->processFacade->createProcess($processData);
            $process = $this->processFacade->updateProcessWithRemovedSubprocess($process, $subprocess);

            $subprocessData = new SubprocessData(
                $request['name'] ?? $subprocess->getName(),
                $request['description'] ?? $subprocess->getDescription(),
                $process,
                $subprocess,
                isset($request['priority']) ? (int)$request['priority'] : $subprocess->getPriority(),
            );

            $subprocess = $this->subprocessFacade->createSubprocess($subprocessData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData($subprocess);
    }
}
