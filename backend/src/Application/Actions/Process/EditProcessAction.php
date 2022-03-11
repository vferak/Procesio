<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Process\ProcessData;
use Psr\Http\Message\ResponseInterface as Response;

class EditProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $process = null;
        $request = $this->request->getParsedBody();

        try {
            $process = $this->processFacade->getProcessByUuid($request['uuid']);

            if(empty($request['comesFrom']))
            {
                //TODO: povolit nullable na promenych comesFrom
                $comesFrom = null;
            } else{
                $comesFrom = $this->processFacade->getProcessByUuid($request['comesFrom']);
            }

            $processData = new ProcessData(
                $request['name'] ?? $process->getName(),
                $request['description'] ?? $process->getDescription(),
                $comesFrom
            );

            $this->processFacade->editProcess($process, $processData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData($process);
    }
}
