<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

class PackageData
{
    public function __construct(private string $name,private string $description)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
