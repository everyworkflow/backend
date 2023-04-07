<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Command;

use EveryWorkflow\MongoBundle\Repository\MigrationRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'mongo:migrate:log')]
class MongoMigrateLogCommand extends Command
{
    public function __construct(
        protected MigrationRepositoryInterface $migrationRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Shows mongo migration log')
            ->setHelp('This command will print mongo migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $inputOutput->title('Mongo migration log');

        $table = new Table($output);
        $table->setHeaders(['UUID', 'Bundle Name', 'File Name', 'Migration Class', 'Migrated At']);

        /* Adding migration data to table format */
        $migrations = $this->migrationRepository->find();
        foreach ($migrations as $migration) {
            $table->addRow([
                $migration->getId(),
                $migration->getBundleName(),
                $migration->getFileName(),
                $migration->getClass(),
                $migration->getMigratedAt(),
            ]);
        }

        $table->render();
        $inputOutput->newLine();

        return Command::SUCCESS;
    }
}
