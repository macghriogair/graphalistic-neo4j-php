<?php

declare(strict_types=1);

namespace Tests\Unit;

use Basilicom\Graphalistic\Neo4j\Client\Factory;
use PHPUnit\Framework\TestCase;
use Tests\Support\GraphawareTrait;

class ExampleGraphTest extends TestCase
{
    use GraphawareTrait;

    public function setUp(): void
    {
        $this->purgeDatabase();
    }

    /** @test */
    public function it_is_empty()
    {
        $this->assertGraphIsEmpty();
    }

    /** @test */
    public function it_creates_a_graph()
    {
        $query = "CREATE (one:Person {name:'Bob'})-[:FRIEND_OF]->(two:Person {name:'Alice'})";

        $neo4j = (new Factory())->makeClient();
        $neo4j->run(
            $query
        );

        $this->assertSameGraph($query);
    }
}
