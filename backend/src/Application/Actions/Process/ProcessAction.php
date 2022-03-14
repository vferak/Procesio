<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Process\ProcessFacade;
use Psr\Log\LoggerInterface;

abstract class ProcessAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected ProcessFacade $processFacade
    ) {
        parent::__construct($logger);
    }
}
