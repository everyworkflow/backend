<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Command;

use EveryWorkflow\MongoBundle\Model\MongoConnectionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'mongo:database:drop')]
class MongoDatabaseDropCommand extends Command
{
    public function __construct(
        protected MongoConnectionInterface $mongoConnection,
        protected string $mongoDb,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Drop mongo database')
            ->setHelp('This command drop mongo database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);
        $this->mongoConnection->getClient()->dropDatabase($this->mongoDb);
        $inputOutput->text('Drop database: ' . $this->mongoDb);

        return Command::SUCCESS;
    }
}
