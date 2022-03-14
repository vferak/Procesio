<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Process\Exceptions\CouldNotDisplayParentProcessException;
use Procesio\Domain\Subprocess\Exceptions\CouldNotDisplayParentSubprocessException;
use Psr\Http\Message\ResponseInterface as Response;

class ViewParentSubprocessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $subprocessId = $this->resolveArg('id');
        $subprocess = $this->subprocessFacade->getSubprocessByUuid($subprocessId);
        if ($subprocess->getComesFrom() === null) {
            throw CouldNotDisplayParentSubprocessException::displaySubprocessDomainObjectClass();
        }

        $subprocess = $this->subprocessFacade->getSubprocessByUuid($subprocess->getComesFrom()->getUuid());

        return $this->respondWithData($subprocess);
    }
}
