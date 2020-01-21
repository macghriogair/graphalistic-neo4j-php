<?php

declare(strict_types=1);

use Example\OGM\Entity\Movie;
use Example\OGM\Entity\Person;

require_once __DIR__ . '/_bootstrap.php';

$name = $argv[1];

$entityManager = \Graphalistic\Neo4j\OGM\EntityManagerFactory::create();

$personsRepository = $entityManager->getRepository(Person::class);

$person = $personsRepository->findOneBy(['name' => $name]);

if ($person === null) {
    echo 'Person not found' . PHP_EOL;
    exit(1);
}

echo sprintf("- %s is born in %d\n", $person->getName(), $person->getBorn());
echo "  The movies in which he acted are : \n";

/** @var Movie $movie */
foreach ($person->getMovies() as $movie) {
    echo sprintf("    -- %s\n", $movie->getTitle());
}
