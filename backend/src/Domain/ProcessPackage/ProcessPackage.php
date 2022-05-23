<?php

declare(strict_types=1);

namespace Procesio\Domain\ProcessPackage;

use JsonSerializable;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Process\Process;

/**
 * @Entity
 * @Table(name="process_package")
 */
class ProcessPackage implements JsonSerializable
{
    /**
     * @Id
     * @ManyToOne(targetEntity="Procesio\Domain\Process\Process", inversedBy="processPackages")
     * @JoinColumn(name="process_uuid", referencedColumnName="uuid", unique=false)
     */
    private Process $process;

    /**
     * @Id
     * @ManyToOne(targetEntity="Procesio\Domain\Package\Package", inversedBy="processPackages")
     * @JoinColumn(name="package_uuid", referencedColumnName="uuid", unique=false)
     */
    private Package $package;

    /** @Column(type="integer") */
    private int $priority;


    public function __construct(ProcessPackageData $processPackageData)
    {
        $this->process = $processPackageData->getProcess();
        $this->package = $processPackageData->getPackage();
        $this->priority = $processPackageData->getPriority();

        $this->process->addProcessPackage($this);
        $this->package->addProcessPackage($this);
    }

    public function jsonSerialize(): array
    {
        return [
            'process' => $this->getProcess()->getUuid(),
            'package' => $this->getPackage()->getUuid(),
            'priority' => $this->getPriority()
        ];
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
