<?php

declare(strict_types=1);

use Graphalistic\Neo4j\Client\Factory;

require_once __DIR__ . '/_bootstrap.php';

// Client
$client = (new Factory())->makeClient();

// Query a result
$result = $client->run('MATCH (c:Category) RETURN c');

dump(
    array_map(function ($r) {
        return $r->values();
    }, $result->records())
);

dump(
    $result->summarize()
);
