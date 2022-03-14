<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Psr\Http\Message\ResponseInterface as Response;

class ViewProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $processId = $this->resolveArg('id');
        $process = $this->processFacade->getProcessByUuid($processId);

        $this->logger->info("Process of id {$processId} was viewed.");

        return $this->respondWithData($process);
    }
}
