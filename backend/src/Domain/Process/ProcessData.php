<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

class ProcessData
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
