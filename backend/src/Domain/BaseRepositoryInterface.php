<?php

declare(strict_types=1);

namespace Procesio\Domain;

interface BaseRepositoryInterface
{
    public function findAll(): array;
}
