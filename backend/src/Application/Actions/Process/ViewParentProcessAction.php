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
        if($process->getComesFrom() === null)
        {
            throw CouldNotDisplayParentProcessException::displayProcessDomainObjectClass();
        }

        $process = $this->processFacade->getProcessByUuid($process->getComesFrom()->getUuid());

        return $this->respondWithData($process);
    }
}
