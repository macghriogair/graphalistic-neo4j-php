<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Query;

use GraphAware\Common\Result\Result;
use GraphAware\Neo4j\Client\Client;

class Cypher
{
    protected Client $client;
    protected string $queryTemplate;
    protected array $parameters;
    private ?Result $result;

    public function __construct(
        Client $client,
        string $queryTemplate,
        array $parameters = []
    ) {
        $this->client = $client;
        $this->queryTemplate = $queryTemplate;
        $this->parameters = $parameters;
    }

    public function run() : void
    {
        $this->setResult(
            $this->client->run($this->buildQuery())
        );
    }

    private function buildQuery(): string
    {
        return sprintf($this->queryTemplate, ... $this->parameters);
    }

    private function setResult(?Result $result) : void
    {
        $this->result = $result;
    }
}