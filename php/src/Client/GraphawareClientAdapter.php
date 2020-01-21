<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Client;

use Graphalistic\Contracts\ClientInterface;
use GraphAware\Neo4j\Client\ClientInterface as DecoratedClientContract;

// TODO.
class GraphawareClientAdapter implements ClientInterface
{
    protected DecoratedClientContract $client;

    public function __construct(DecoratedClientContract $client)
    {
        $this->client = $client;
    }
}
