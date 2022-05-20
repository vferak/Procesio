<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\ProcessPackage;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Package\PackageFacade;
use Procesio\Domain\Process\ProcessFacade;
use Procesio\Domain\ProcessPackage\ProcessPackageFacade;
use Procesio\Domain\Workspace\WorkspaceFacade;
use Psr\Log\LoggerInterface;

abstract class ProcessPackageAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected PackageFacade $packageFacade,
        protected ProcessFacade $processFacade,
        protected WorkspaceFacade $workspaceFacade,
        protected ProcessPackageFacade $processPackageFacade
    ) {
        parent::__construct($logger);
    }
}
