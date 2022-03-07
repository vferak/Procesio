<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Psr\Http\Message\ResponseInterface as Response;

class ViewSubprocessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $subprocessId = $this->resolveArg('id');
        $subprocess= $this->subprocessFacade->getSubprocessByUuid($subprocessId);

        $this->logger->info("Subprocess of id {$subprocessId} was viewed.");

        return $this->respondWithData($subprocess);
    }
}
