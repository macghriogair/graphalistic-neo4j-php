<?php

declare(strict_types=1);

namespace Graphalistic\Neo4j\Console\Command;

use Graphalistic\Neo4j\Client\Factory;
use GraphAware\Bolt\Result\Type\Node;
use GraphAware\Common\Result\RecordViewInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RawQueryCommand extends Command
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
            ->setName('graphalistic:query')
            ->addArgument(
                'query',
                InputArgument::REQUIRED,
                'Raw cypher query to execute.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = $input->getArgument('query');
        $output->writeln($query);

        $client = $this->clientFactory->makeClient();

        $result = $client->run($query);

        if ($result->size() > 0) {
            $table = new Table($output);

            /** @var RecordViewInterface $rec */
            $table->setHeaders($result->firstRecord()->keys());

            foreach ($result->records() as $rec) {
                $cells = [];
                foreach ($rec->values() as $value) {
                    if ($value instanceof Node) {
                        $cells[] = implode('|', $value->values());
                    } else {
                        $cells[] = $value;
                    }
                }
                $table->addRow($cells);
            }

            $table->render();
        } else {
            $output->writeln('No Records.');
        }

        return 0;
    }
}
