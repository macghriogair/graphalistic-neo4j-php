<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Console\Command;

use Graphalistic\Neo4j\Client\Factory;
use Graphalistic\Neo4j\Command\PurgeDatabaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteAllCommand extends Command
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
            ->setName('graphalistic:purge')
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('force') !== true) {
            throw new \InvalidArgumentException('Force flag must be provided!');
        }

        $cmd = new PurgeDatabaseCommand($this->clientFactory->makeClient());
        $cmd->execute();

        $output->writeln('If no errors showed up, database has been cleared!');

        return 0;
    }
}