<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Command;

use GraphAware\Neo4j\Client\ClientInterface;

class LoadCsvCommand extends Command
{
    protected LoadCsvRequest $request;

    public function __construct(
        ClientInterface $client,
        LoadCsvRequest $request
    ) {
        parent::__construct($client);

        $this->request = $request;
    }

    public function execute(): void
    {
        /*
         LOAD CSV WITH HEADERS FROM "http://data.neo4j.com/northwind/products.csv" AS row
        CREATE (n:Product)
        SET n = row,
          n.unitPrice = toFloat(row.unitPrice),
          n.unitsInStock = toInteger(row.unitsInStock), n.unitsOnOrder = toInteger(row.unitsOnOrder),
          n.reorderLevel = toInteger(row.reorderLevel), n.discontinued = (row.discontinued <> "0")
        */

        $query = sprintf(
            'LOAD CSV WITH HEADERS FROM "%s" AS row
            CREATE (n:%s)
            SET n = row',
            $this->request->getCsvUri(),
            $this->request->getNodeName()
        );

        $result = $this->client->run($query);

        dd($result);
    }
}
