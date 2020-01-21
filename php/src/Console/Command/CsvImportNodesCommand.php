<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Console\Command;

use Graphalistic\Neo4j\Client\Factory;
use Graphalistic\Neo4j\Command\LoadCsvCommand;
use Graphalistic\Neo4j\Command\LoadCsvRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CsvImportNodesCommand extends Command
{
    /** @var Factory */
    private Factory $clientFactory;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->clientFactory = new Factory();
    }

    protected function configure()
    {
        $this
            ->setName('graphalistic:csv-import:nodes')
            ->addArgument(
                'node-label',
                InputArgument::REQUIRED,
                'Label of nodes to be created.'
            )
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Path/Url of csv file to load.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nodeLabel = $input->getArgument('node-label');
        $csvUri = $input->getArgument('source');

        $client = (new Factory())->makeClient();
        $cmd = new LoadCsvCommand($client,
            new LoadCsvRequest($csvUri, $nodeLabel, [])
        );
        $cmd->execute();

        $output->writeln('Done!');
        return 0;
    }
}