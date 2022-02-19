<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Procesio\Bootstrap;
use Procesio\Infrastructure\Doctrine\EntityManagerFactory;

require __DIR__ . '/vendor/autoload.php';

$bootstrap = new Bootstrap();
$container = $bootstrap->getContainer();

$config = new PhpFile('migrations.php');

$entityManagerFactory = $container->get(EntityManagerFactory::class);
$entityManager = $entityManagerFactory->createEntityManager();

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
