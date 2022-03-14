<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Process\Exceptions\CouldNotDisplayParentProcessException;
use Procesio\Domain\Process\ProcessData;
use Psr\Http\Message\ResponseInterface as Response;

class EditProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->getFormData();

        try {
            $process = $this->processFacade->getProcessByUuid($request->uuid);
        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        }
        $comesFrom = $process->getComesFrom();

        $processData = new ProcessData(
            $request->name ?? $process->getName(),
            $request->description ?? $process->getDescription(),
            $comesFrom
        );

        $this->processFacade->editProcess($process, $processData);

        return $this->respondWithData($process);
    }
}
