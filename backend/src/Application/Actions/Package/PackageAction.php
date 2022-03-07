<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Package;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Package\PackageFacade;
use Psr\Log\LoggerInterface;

abstract class PackageAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected PackageFacade $packageFacade
    ) {
        parent::__construct($logger);
    }
}