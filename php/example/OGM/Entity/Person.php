<?php

declare(strict_types=1);

namespace Example\OGM\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * Class Person
 * cf. https://neo4j-php-ogm.readthedocs.io/en/latest/getting_started/tutorial/#an-example-model-the-movie-database
 *
 * @OGM\Node(label="Person")
 */
class Person
{
    /**
     * @var int|null
     * @OGM\GraphId()
     */
    protected ?int $id;

    /**
     * @var string|null
     * @OGM\Property(type="string")
     */
    protected ?string $name;

    /**
     * @var int|null
     * @OGM\Property(type="int")
     */
    protected ?int $born;

    /**
     * @var Movie[]|Collection
     *
     * @OGM\Relationship(
     *     type="ACTED_IN",
     *     direction="OUTGOING",
     *     collection=true,
     *     mappedBy="actors",
     *     targetEntity="Movie"
     * )
     */
    protected $movies;

    public function __construct()
    {
        $this->movies = new Collection();
    }

    /**
     * @return Movie[]|Collection
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getBorn() : ?int
    {
        return $this->born;
    }

    /**
     * @param int|null $born
     */
    public function setBorn(?int $born) : void
    {
        $this->born = $born;
    }
}
