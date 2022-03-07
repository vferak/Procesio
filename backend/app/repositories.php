<?php
declare(strict_types=1);

use Procesio\Domain\Package\PackageRepositoryInterface;
use Procesio\Domain\Project\ProjectRepositoryInterface;
use Procesio\Domain\User\UserRepositoryInterface;
use DI\ContainerBuilder;
use Procesio\Domain\Workspace\WorkspaceRepositoryInterface;
use Procesio\Infrastructure\Doctrine\Repositories\PackageRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectRepository;
use Procesio\Infrastructure\Doctrine\Repositories\UserRepository;
use Procesio\Infrastructure\Doctrine\Repositories\WorkspaceRepository;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepositoryInterface::class => \DI\autowire(UserRepository::class),
        WorkspaceRepositoryInterface::class => \DI\autowire(WorkspaceRepository::class),
        PackageRepositoryInterface::class => \DI\autowire(PackageRepository::class),
        ProjectRepositoryInterface::class => \DI\autowire(ProjectRepository::class),
    ]);
};
