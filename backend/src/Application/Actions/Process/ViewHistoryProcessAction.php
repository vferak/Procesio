<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Psr\Http\Message\ResponseInterface as Response;

class ViewHistoryProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $processId = $this->resolveArg('id');

        $process = $this->processFacade->getProcessesByComesFrom($processId);

        return $this->respondWithData($process);
    }
}
