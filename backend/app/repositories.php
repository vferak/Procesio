<?php
declare(strict_types=1);

use Procesio\Domain\User\UserRepositoryInterface;
use DI\ContainerBuilder;
use Procesio\Infrastructure\Doctrine\Repositories\UserRepository;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepositoryInterface::class => \DI\autowire(UserRepository::class),
    ]);
};
