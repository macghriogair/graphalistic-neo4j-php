<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\OGM;

use GraphAware\Neo4j\OGM\EntityManager;

class EntityManagerFactory
{
    public static function create(): EntityManager
    {
        $driverProtocol = getenv('NEO4J_DRIVER_PROTOCOL');
        $port = (int) getenv('NEO4J_PORT');

        if (! $port) {
            if ('bolt' === $driverProtocol) {
                $port = 7687;
            } elseif ('http' === $driverProtocol) {
                $port = 7474;
            } elseif ('https' === $driverProtocol) {
                $port = 7473;
            }
        }

        $connectionString = sprintf(
            '%s://%s:%s@%s:%d',
            $driverProtocol,
            getenv('NEO4J_AUTH_USER'),
            getenv('NEO4J_AUTH_PASS'),
            getenv('NEO4J_HOST'),
            $port
        );

        return EntityManager::create($connectionString);
    }
}
