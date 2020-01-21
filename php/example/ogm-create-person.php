<?php

declare(strict_types=1);

use Example\OGM\Entity\Person;

require_once __DIR__ . '/_bootstrap.php';

$entityManager = \Graphalistic\Neo4j\OGM\EntityManagerFactory::create();

// create a Person
$newPersonName = $argv[1];
$newPersonBorn = (int) $argv[2];

$person = new Person();
$person->setName($newPersonName);
$person->setBorn($newPersonBorn);

$entityManager->persist($person);
$entityManager->flush();

echo sprintf('Created Person with ID "%d"', $person->getId()) . PHP_EOL;
{}