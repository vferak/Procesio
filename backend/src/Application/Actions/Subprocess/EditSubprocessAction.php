<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
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
            $exists_comesFrom = array_key_exists('comesFrom', $request);
            if ($exists_comesFrom) {
                if ($request['comesFrom'] == null) {
                    $comesFrom = null;
                } else {
                    $comesFrom = $this->subprocessFacade->getSubprocessByUuid($request['comesFrom']);
                }
            } else {
                $comesFrom = $subprocess->getComesFrom();
            }

            $exists_process = array_key_exists('process', $request);
            if ($exists_process) {
                if ($request['process'] == null) {
                    $process = null;
                } else {
                    $process = $this->processFacade->getProcessByUuid($request['process']);
                }
            } else {
                $process = $subprocess->getProcess();
            }

            $subprocessData = new SubprocessData(
                $request['name'] ?? $subprocess->getName(),
                $request['description'] ?? $subprocess->getDescription(),
                $process,
                $comesFrom
            );

            $this->subprocessFacade->editSubprocess($subprocess, $subprocessData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData($subprocess);
    }
}
