<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Process\Exceptions\CouldNotDisplayParentProcessException;
use Psr\Http\Message\ResponseInterface as Response;

class ViewParentProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $processId = $this->resolveArg('id');
        $process = $this->processFacade->getProcessByUuid($processId);

        $process = $process->getComesFrom();

        if ($process === null) {
            return $this->respondWithData("Can not display parent of this!", 404);
        }

        return $this->respondWithData($process);
    }
}
