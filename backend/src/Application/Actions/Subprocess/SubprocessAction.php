<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Subprocess\SubprocessFacade;
use Psr\Log\LoggerInterface;

abstract class SubprocessAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected SubprocessFacade $subprocessFacade
    ) {
        parent::__construct($logger);
    }
}