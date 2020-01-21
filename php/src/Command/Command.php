<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Command;

use GraphAware\Neo4j\Client\ClientInterface;

abstract class Command
{
    protected ClientInterface $client;

    protected $result;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getResult()
    {
        return $this->result;
    }

    abstract public function execute() : void;
}