<?php

declare(strict_types=1);

namespace Procesio\Infrastructure\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Procesio\Application\Settings\SettingsInterface;

class EntityManagerFactory
{
    public function __construct(
        private SettingsInterface $settings
    ) {
    }

    public function createEntityManager(): EntityManager
    {
        $isDevMode = $this->settings->get('development');
        $paths = [__DIR__ . '/../..'];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $database = $this->settings->get('database');
        $dbParams = [
            'driver' => $database['driver'],
            'user' => $database['user'],
            'password' => $database['password'],
            'dbname' => $database['dbname'],
            'host' => $database['host'],
            'port' => $database['port'],
            'charset' => 'utf8mb4'
        ];

        $connection = DriverManager::getConnection($dbParams);
        return EntityManager::create($connection, $config);
    }
}
