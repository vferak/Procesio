<?php

declare(strict_types=1);

namespace Procesio\Domain\ProcessPackage;

use Procesio\Domain\Package\Package;
use Procesio\Domain\Process\Process;

class ProcessPackageData
{
    public function __construct(
        private Process $process,
        private Package $package,
        private int $priority
    ) {
    }

    /**
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->process;
    }

    /**
     * @return Package
     */
    public function getPackage(): Package
    {
        return $this->package;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

}
