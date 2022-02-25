<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

class PackageData
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /*public function getPassword(): string
    {
        return $this->password;
    }*/
}
