<?php

declare(strict_types=1);

namespace Procesio\Domain\State;

class StateData
{
    public function __construct(
        private string $name
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}
