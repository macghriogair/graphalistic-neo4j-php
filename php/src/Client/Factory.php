<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Client;

use GraphAware\Neo4j\Client\ClientBuilder;
use GraphAware\Neo4j\Client\ClientInterface;

class Factory
{
    protected string $driverProtocol;

    protected string $user;

    protected string $pass;

    protected string $host;

    protected int $port;

    public function __construct()
    {
        $this->driverProtocol = getenv('NEO4J_DRIVER_PROTOCOL');
        $this->user = getenv('NEO4J_AUTH_USER');
        $this->pass = getenv('NEO4J_AUTH_PASS');
        $this->host = getenv('NEO4J_HOST');

        $port = (int) getenv('NEO4J_PORT');
        if (! $port) {
            if ('bolt' === $this->driverProtocol) {
                $port = 7687;
            } elseif ('http' === $this->driverProtocol) {
                $port = 7474;
            } elseif ('https' === $this->driverProtocol) {
                $port = 7473;
            }
        }
        $this->port = $port;
    }

    public function makeClient(): ClientInterface
    {
        return ClientBuilder::create()
            ->addConnection('default', $this->connectionString())
            ->build();
    }

    private function connectionString(): string
    {
        return sprintf(
            '%s://%s:%s@%s:%d',
            $this->driverProtocol,
            $this->user,
            $this->pass,
            $this->host,
            $this->port
        );
    }
}
