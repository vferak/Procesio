<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Psr\Http\Message\ResponseInterface as Response;

class ViewHistorySubprocessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $subprocessId = $this->resolveArg('id');

        $subprocess = $this->subprocessFacade->getSubprocessesByComesFrom($subprocessId);

        return $this->respondWithData($subprocess);
    }
}
