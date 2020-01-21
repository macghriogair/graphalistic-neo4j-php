<?php

declare(strict_types=1);

namespace Tests\Support;

use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client;
use PHPUnit\Framework\Assert;

trait GraphawareTrait
{
    private ?Client $httpClient = null;

    private function client()
    {
        if (is_null($this->httpClient)) {
            $baseUri = sprintf(
                'http://%s:%s@%s:%d',
                getenv('NEO4J_AUTH_USER'),
                getenv('NEO4J_AUTH_PASS'),
                getenv('NEO4J_HOST'),
                7474
            );

            $this->httpClient = Client::createWithConfig([
                'base_uri' => $baseUri,
                'timeout' => 10
            ]);

        }

        return $this->httpClient;
    }

    public function purgeDatabase() : void
    {
        $this->client()->sendRequest(
            new Request('POST', 'graphaware/resttest/clear')
        );
    }

    public function assertGraphIsEmpty() : void
    {
        $response = $this->client()->sendRequest(
            new Request('POST', 'graphaware/resttest/assertEmpty')
        );

        Assert::assertEquals(200, $response->getStatusCode());
    }

    public function assertSameGraph(string $body) : void
    {
        $requestBody = json_encode([
            'cypher' => $body
        ]);

        $response = $this->client()->sendRequest(
            new Request('POST', 'graphaware/resttest/assertSameGraph', [
                'Content-Type' => 'application/json'
            ], $requestBody)
        );

        Assert::assertEquals(200, $response->getStatusCode());
    }

    public function assertSubgraph(string $body) : void
    {
        $requestBody = json_encode([
            'cypher' => $body
        ]);

        $response = $this->client()->sendRequest(
            new Request('POST', 'graphaware/resttest/assertSubgraph', [
                'Content-Type' => 'application/json'
            ], $requestBody)
        );

        Assert::assertEquals(200, $response->getStatusCode());
    }
}
