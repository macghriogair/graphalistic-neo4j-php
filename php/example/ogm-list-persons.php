<?php

declare(strict_types=1);

use Example\OGM\Entity\Person;

require_once __DIR__ . '/_bootstrap.php';

$entityManager = \Graphalistic\Neo4j\OGM\EntityManagerFactory::create();

$personsRepository = $entityManager->getRepository(Person::class);
$persons = $personsRepository->findAll();

foreach ($persons as $person) {
    echo sprintf("- %s\n", $person->getName());
}
