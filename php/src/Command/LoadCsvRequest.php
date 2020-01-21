<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Command;

class LoadCsvRequest
{
    protected string $csvUri;
    protected string $nodeName;
    protected array $transformers;

    public function __construct(
        string $csvUri,
        string $nodeName,
        array $transformers = []
    )
    {
        $this->csvUri = $csvUri;
        $this->nodeName = $nodeName;
        $this->transformers = $transformers;
    }

    /**
     * @return string
     */
    public function getCsvUri() : string
    {
        return $this->csvUri;
    }

    /**
     * @return string
     */
    public function getNodeName() : string
    {
        return $this->nodeName;
    }

    /**
     * @return array
     */
    public function getTransformers() : array
    {
        return $this->transformers;
    }
}