<?php

declare(strict_types=1);

namespace Example\OGM\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Movie")
 */
class Movie
{
    /**
     * @var int|null
     *
     * @OGM\GraphId()
     */
    protected ?int $id;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected ?string $title;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected ?string $tagline;

    /**
     * @var int
     *
     * @OGM\Property(type="int")
     */
    protected ?int $released;

    /**
     * @var Person[]|Collection
     *
     * @OGM\Relationship(type="ACTED_IN", direction="INCOMING", collection=true, mappedBy="movies", targetEntity="Person")
     */
    protected $actors;

    public function __construct()
    {
        $this->actors = new Collection();
    }

    // other code

    /**
     * @return Person[]|Collection
     */
    public function getActors()
    {
        return $this->actors;
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
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTagline() : string
    {
        return $this->tagline;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline) : void
    {
        $this->tagline = $tagline;
    }

    /**
     * @return int
     */
    public function getReleased() : int
    {
        return $this->released;
    }

    /**
     * @param int $released
     */
    public function setReleased(int $released) : void
    {
        $this->released = $released;
    }
}
