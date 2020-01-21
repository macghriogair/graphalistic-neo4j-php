<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Command;

class PurgeDatabaseCommand extends Command
{
    public function execute(): void
    {
        $this->result = $this->client->run(
            'MATCH (n) DETACH DELETE n'
        );
    }
}
